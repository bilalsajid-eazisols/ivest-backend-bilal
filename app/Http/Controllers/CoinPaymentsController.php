<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Web3\Web3;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Utils as Web3Utils;
use Web3\Personal;
use Web3p\EthereumTx\Transaction;
use App\Models\Transaction as Transactions;

class CoinPaymentsController extends Controller
{
    private $apiUrl;
    private $apiKey;
    private $apiSecret;
    private $ipnApiSecret;
    private $web3;
    private $personal;
    private $networkConfig;
    private $contract;
    private $rewardWalletAddress;
    private $rewardWalletPrivateKey;

    public function __construct()
    {
        // CoinPayments Configuration
        $this->apiUrl = env('COINPAYMENTS_API_URL', 'https://www.coinpayments.net/api.php');
        $this->apiKey = env('COINPAYMENTS_API_KEY');
        $this->apiSecret = env('COINPAYMENTS_API_SECRET');
        $this->ipnApiSecret = env('COINPAYMENTS_IPN_SECRET');

        // Setup network configuration
        $this->setupNetworkConfig();

        // Initialize Web3 with appropriate network
        $this->initializeWeb3();

        // Set wallet credentials
        $this->rewardWalletAddress = env('REWARD_WALLET_ADDRESS');
        $this->rewardWalletPrivateKey = env('REWARD_WALLET_PRIVATE_KEY');
    }

    private function setupNetworkConfig()
    {
        $environment = env('APP_ENV');
        $network = env('BLOCKCHAIN_NETWORK', 'testnet');

        $configs = [
            'testnet' => [
                'nodeUrl' => env('BSC_NODE_URL', 'https://data-seed-prebsc-1-s1.binance.org:8545/'),
                'chainId' => 97,
                'networkName' => 'BSC Testnet',
                'explorerUrl' => 'https://testnet.bscscan.com/tx/',
                'gasLimit' => 21000,
                'payment' => [
                    'currency' => env('TEST_PAYMENT_CURRENCY', 'LTCT')
                ]
            ],
            'mainnet' => [
                'nodeUrl' => env('ETH_MAINNET_URL'),
                'chainId' => 1,
                'networkName' => 'Ethereum Mainnet',
                'explorerUrl' => 'https://etherscan.io/tx/',
                'gasLimit' => 100000,
                'payment' => [
                    'currency' => 'USDT'
                ],
                'token' => [
                    'address' => env('IVT_TOKEN_ADDRESS'),
                    'decimals' => env('IVT_TOKEN_DECIMALS', 18)
                ]
            ]
        ];

        if (in_array($environment, ['local', 'development']) && $network !== 'mainnet') {
            $this->networkConfig = $configs['testnet'];
        } else {
            $this->networkConfig = $configs['mainnet'];
        }
    }

    private function initializeWeb3()
    {
        $provider = new HttpProvider(new HttpRequestManager(
            $this->networkConfig['nodeUrl'],
            30
        ));
        $this->web3 = new Web3($provider);
        $this->personal = new Personal($provider);

        if ($this->isMainnet()) {
            $this->initializeERC20Contract();
        }
    }

    private function initializeERC20Contract()
    {
        $abi = '[{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"}]';
        
        $this->contract = new Contract($this->web3->provider, $abi);
    }

    private function isMainnet()
    {
        return $this->networkConfig['chainId'] === 1;
    }

    // Your existing utility methods
    private function createSignature($params)
    {
        $queryString = http_build_query($params);
        return hash_hmac('sha512', $queryString, $this->apiSecret);
    }

    private function makeRequest($params)
    {
        $params['version'] = 1;
        $params['key'] = $this->apiKey;
        $params['format'] = 'json';

        $signature = $this->createSignature($params);

        $response = Http::withHeaders([
            'HMAC' => $signature
        ])->asForm()->post($this->apiUrl, $params);

        return $response->json();
    }

    private function toHex($value)
    {
        if (is_object($value) && get_class($value) === 'phpseclib\Math\BigInteger') {
            return '0x' . $value->toHex();
        }
        return '0x' . dechex($value);
    }

    private function toWei($amount)
    {
        $formattedAmount = number_format($amount, 18, '.', '');
        $formattedAmount = rtrim(rtrim($formattedAmount, '0'), '.');
        
        \Log::info('Converting amount to wei', [
            'original_amount' => $amount,
            'formatted_amount' => $formattedAmount
        ]);
        
        return Web3Utils::toWei($formattedAmount, 'ether');
    }

    // Your existing public API methods
    public function getRates()
    {
        $rates = $this->makeRequest(['cmd' => 'rates']);
        return response()->json($rates);
    }

    public function getTransactionStatus(Request $request)
    {
        $request->validate([
            'txid' => 'required|string'
        ]);

        $status = $this->makeRequest([
            'cmd' => 'get_tx_info',
            'txid' => $request->txid
        ]);

        return response()->json($status);
    }

    public function createUSDTTransaction(Request $request)
    {
        $request->validate([
            'amountusdt' => 'required|numeric|min:0.00001',
            'amountivt' => 'required|numeric|min:0.00001',
            'buyer_email' => 'required|email'
        ]);

        $payment = $this->makeRequest([
            'cmd' => 'create_transaction',
            'amount' => $request->amountusdt,
            'currency1' => $request->currency1,
            'currency2' => $request->currency2,
            'buyer_email' => $request->buyer_email,
            'custom' => auth()->id(),
        ]);

        if ($payment['error'] !== 'ok') {
            return response()->json(['error' => 'Failed to create transaction'], 400);
        }

        $txn_id = $payment['result']['txn_id'];
        $checkout_url = $payment['result']['checkout_url'] ?? null;
        $status_url = $payment['result']['status_url'] ?? null;
        $qrcode_url = $payment['result']['qrcode_url'] ?? null;

        $transaction = Transactions::create([
            'username' => $request->username,
            'email' => $request->buyer_email,
            'transaction_id' => $txn_id,
            'user_wallet_address' => $request->user_wallet_address,
            'tx_hash' => null,
            'status' => 'created',
            'amount_usdt' => $request->amountusdt,
            'amount_ivt' => $request->amountivt,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'message' => 'Transaction created successfully',
            'transaction' => $transaction,
            'payment_urls' => [
                'checkout_url' => $checkout_url,
                'status_url' => $status_url,
                'qrcode_url' => $qrcode_url
            ]
        ], 201);
    }

    public function getAllTransactions(Request $request)
    {
        $userId = $request->query('user_id', 0);

        if ($userId == 0) {
            $transactions = Transactions::all();
        } else {
            $transactions = Transactions::where('user_id', $userId)->get();
        }

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    private function sendReward($recipientAddress, $amount)
    {
        try {
            if ($this->isMainnet()) {
                $result = $this->sendERC20Tokens($recipientAddress, $amount);
            } else {
                $result = $this->sendTestnetTokens($recipientAddress, $amount);
            }

            if (!$result['success']) {
                throw new \Exception($result['error']);
            }

            \Log::info('Tokens sent successfully', [
                'tx_hash' => $result['tx_hash'],
                'amount' => $amount,
                'recipient' => $recipientAddress,
                'network' => $this->networkConfig['networkName']
            ]);

            return $result;

        } catch (\Exception $e) {
            \Log::error('Error sending tokens', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'network' => $this->networkConfig['networkName']
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function sendTestnetTokens($recipientAddress, $amount)
    {
        $result = null;
        $error = null;

        $this->web3->eth->getTransactionCount(
            $this->rewardWalletAddress,
            'latest',
            function ($err, $nonce) use (&$result, &$error, $recipientAddress, $amount) {
                if ($err !== null) {
                    $error = $err;
                    return;
                }

                $this->web3->eth->gasPrice(function ($err, $gasPrice) use ($nonce, &$result, &$error, $recipientAddress, $amount) {
                    if ($err !== null) {
                        $error = $err;
                        return;
                    }

                    try {
                        $weiAmount = $this->toWei($amount);

                        $transaction = new Transaction([
                            'nonce' => $this->toHex($nonce),
                            'gasPrice' => $this->toHex($gasPrice),
                            'gasLimit' => $this->toHex($this->networkConfig['gasLimit']),
                            'to' => $recipientAddress,
                            'value' => $this->toHex($weiAmount),
                            'data' => '',
                            'chainId' => $this->networkConfig['chainId']
                        ]);

                        $signedTransaction = $transaction->sign(str_replace('0x', '', $this->rewardWalletPrivateKey));

                        $this->web3->eth->sendRawTransaction('0x' . $signedTransaction, function ($err, $txHash) use (&$result, &$error) {
                            if ($err !== null) {
                                $error = $err;
                                return;
                            }
                            $result = $txHash;
                        });
                    } catch (\Exception $e) {
                        $error = $e;
                    }
                });
            }
        );

        if ($error) {
            throw new \Exception($error);
        }

        return [
            'success' => true,
            'tx_hash' => $result
        ];
    }

    private function sendERC20Tokens($recipientAddress, $amount)
    {
        $result = null;
        $error = null;

        $tokenDecimals = $this->networkConfig['token']['decimals'];
        $tokenAmount = bcmul($amount, bcpow('10', $tokenDecimals));

        $data = $this->contract->at($this->networkConfig['token']['address'])->getData(
            'transfer',
            $recipientAddress,
            $tokenAmount
        );

        $this->web3->eth->getTransactionCount(
            $this->rewardWalletAddress,
            'latest',
            function ($err, $nonce) use (&$result, &$error, $recipientAddress, $data) {
                if ($err !== null) {
                    $error = $err;
                    return;
                }

                $this->web3->eth->gasPrice(function ($err, $gasPrice) use ($nonce, &$result, &$error, $data) {
                    if ($err !== null) {
                        $error = $err;
                        return;
                    }

                    try {
                        $transaction = new Transaction([
                            'nonce' => $this->toHex($nonce),
                            'gasPrice' => $this->toHex($gasPrice),
                            'gasLimit' => $this->toHex($this->networkConfig['gasLimit']),
                            'to' => $this->networkConfig['token']['address'],
                            'value' => '0x0',
                            'data' => $data,
                            'chainId' => $this->networkConfig['chainId']
                        ]);

                        $signedTransaction = $transaction->sign(str_replace('0x', '', $this->rewardWalletPrivateKey));

                        $this->web3->eth->sendRawTransaction('0x' . $signedTransaction, function ($err, $txHash) use (&$result, &$error) {
                            if ($err !== null) {
                                $error = $err;
                                return;
                            }
                            $result = $txHash;
                        });
                    } catch (\Exception $e) {
                        $error = $e;
                    }
                });
            }
        );

        if ($error) {
            throw new \Exception($error);
        }

        return [
            'success' => true,
            'tx_hash' => $result
        ];
    }

    public function handleIPN(Request $request)
    {
        $ipnSecret = env('COINPAYMENTS_IPN_SECRET');
        $rawData = file_get_contents("php://input");
        $receivedHmac = $request->header('HMAC');
        $calculatedHmac = hash_hmac('sha512', $rawData, $ipnSecret);

        $status = $request->input('status');
        $currency = $request->input('currency');
        $amountusdt = floatval($request->input('amountusdt'));
        $txn_id = $request->input('txn_id');
        $user_email = $request->input('user_email');
        $user_wallet_address = $request->input('user_wallet_address');
        $transfer_amount_ivt = floatval($request->input('amountivt'));

        \Log::info('Processing IPN Request:', [
            'txn_id' => $txn_id,
            'status' => $status,
            'currency' => $currency,
            'amountusdt' => $amountusdt,
            'user_email' => $user_email,
            'user_wallet_address' => $user_wallet_address,
            'transfer_amount_ivt' => $transfer_amount_ivt,
            'network' => $this->networkConfig['networkName']
        ]);

        // Find transaction in database
        $transaction = Transactions::where('transaction_id', $txn_id)->first();

        if (!$transaction) {
            \Log::error('Transaction not found:', ['txn_id' => $txn_id]);
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // If transaction is already completed, do not proceed
        if ($transaction->status === 'completed') {
            \Log::info('Transaction already completed:', ['txn_id' => $txn_id]);
            return response()->json(['message' => 'Transaction already completed'], 200);
        }

        // Update transaction status to "payment-received"
        $transaction->status = 'payment-received';
        $transaction->save();

        if ($status == 100 && $currency == 'IVT') {
            \Log::info('Valid transaction detected, proceeding with token transfer');

            try {
                // Send tokens
                $sendResult = $this->sendReward($user_wallet_address, $transfer_amount_ivt);

                if ($sendResult['success']) {
                    // Update status to "completed"
                    $transaction->status = 'completed';
                    $transaction->tx_hash = $sendResult['tx_hash'];
                    $transaction->save();

                    return response()->json([
                        'message' => 'Tokens sent successfully',
                        'tx_hash' => $sendResult['tx_hash'],
                        'network' => $this->networkConfig['networkName']
                    ]);
                } else {
                    \Log::error('Failed to send tokens', ['error' => $sendResult['error']]);
                    return response()->json([
                        'error' => 'Failed to send tokens',
                        'details' => $sendResult['error'],
                        'network' => $this->networkConfig['networkName']
                    ], 500);
                }
            } catch (\Exception $e) {
                \Log::error('Exception in IPN handler', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'network' => $this->networkConfig['networkName']
                ]);

                return response()->json([
                    'error' => 'Internal server error',
                    'message' => $e->getMessage(),
                    'network' => $this->networkConfig['networkName']
                ], 500);
            }
        }

        return response()->json([
            'status' => 'received',
            'message' => 'IPN processed',
            'network' => $this->networkConfig['networkName']
        ]);
    }
}