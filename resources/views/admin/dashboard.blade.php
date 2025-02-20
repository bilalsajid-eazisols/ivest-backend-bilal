@extends('layouts.admin')
@section('content')
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Dashboard</h3>
                        <div class="nk-block-des text-soft">
                            <p>Welcome {{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle"><a href="#"
                                class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="row g-4 mb-5">
                    @can('user_view')
                    <div class="col-sm-6 col-md-3 col-xxl-12">
                        <div class="nk-order-ovwg-data border border-success rounded p-3 shadow-sm">
                            <div class="amount text-success text-center">
                                <h5 class="mb-1">Total Customers</h5>

                            </div>

                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <strong class="display-4 text-dark">{{$usercount}}</strong>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{route('users')}}" class="btn btn-success btn-sm text-white">
                                    <em class="icon ni ni-user-list"></em> View All
                                </a>
                            </div>
                        </div>
                    </div>

                    @endcan
                    @can('membershipclub_view')
                    <div class="col-sm-6 col-md-3 col-xxl-12">
                        <div class="nk-order-ovwg-data border border-primary rounded p-3 shadow-sm">
                            <div class="amount text-primary text-center">
                                <h5 class="mb-1">Total Clubs</h5>

                            </div>

                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <strong class="display-4 text-dark">{{$clubcout}}</strong>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{route('membershipclubs')}}" class="btn btn-primary btn-sm text-white">
                                    <em class="icon ni ni-view-grid-fill"></em> View All
                                </a>
                            </div>
                        </div>
                    </div>

                    @endcan
                    @can('blog_view')
                    <div class="col-sm-6 col-md-3 col-xxl-12">
                        <div class="nk-order-ovwg-data border border-danger rounded p-3 shadow-sm">
                            <div class="amount text-danger text-center">
                                <h5 class="mb-1">Total Blogs</h5>

                            </div>

                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <strong class="display-4 text-dark">{{$blogcount}}</strong>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{route('blogs')}}" class="btn btn-danger btn-sm text-white">
                                    <em class="icon ni ni-text-rich"></em> View All
                                </a>
                            </div>
                        </div>
                    </div>

                    @endcan
                    @can('blog_view')
                    <div class="col-sm-6 col-md-3 col-xxl-12">
                        <div class="nk-order-ovwg-data border border-warning rounded p-3 shadow-sm">
                            <div class="amount text-warning text-center">
                                <h5 class="mb-1">Total News</h5>

                            </div>

                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <strong class="display-4 text-dark">{{$newscount}}</strong>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{route('news')}}" class="btn btn-warning btn-sm text-white">
                                    <em class="icon ni ni-article"></em> View All
                                </a>
                            </div>
                        </div>
                    </div>

                    @endcan
                </div>

                <div class="row g-gs ">
                    @can('user_view')


                 <div class="col-lg-5 my-3">
                    <div class="card card-bordered card-full">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">New Users</h6>
                                    </div>
                                    <div class="card-tools"> <a href="{{route('users')}}" class="link">View
                                            All</a> </div>
                                </div>
                            </div>
                            @foreach ($latestusers as $user)
                            <div class="card-inner card-inner-md">
                                <div class="user-card">
                                    <div class="user-avatar " style="background-image: url({{$user->profileImage()}})
                                        ; background-position: center center; background-size: cover;
                                         height:50px; width:50px" >  </div>
                                    <div class="user-info"> <span class="lead-text">{{$user->FirstName}} {{$user->LastName}}</span> <span
                                            class="sub-text">{{$user->email}}</span> </div>
                                    <div class="user-action">
                                        <a href="{{url("admin/user/$user->id")}}">
                                            <em class="icon ni ni-eye"></em>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>
                    </div><!-- .card -->
                 </div>
                 @endcan
                 <div class="col-lg-7 my-3">
                    <div class="card card-bordered h-100">
                        <div class="card-inner ">
                            <div class="card-title-group">
                                <div class="card-title card-title-sm">
                                    <h6 class="title">Membership Clubs  members</h6>
                                    <p>Membership Clubs  members metrics.</p>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white"
                                           data-bs-toggle="dropdown" id="durationDropdown">30 Days</a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="dropdown-item" data-duration="30days"><span>30 Days</span></a></li>

                                                <li><a href="#" class="dropdown-item" data-duration="6months"><span>6 months</span></a></li>
                                                <li><a href="#" class="dropdown-item" data-duration="1year"><span>1year</span></a></li>

                                            </ul>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>
                            <canvas id="membershipClubChart" width="400" height="200"></canvas>
                        </div>

                    </div>
                </div>
                @can('user_view')


                <div class="col-lg-5 my-3">
                   <div class="card card-bordered card-full">
                       <div class="card-inner-group">
                           <div class="card-inner">
                               <div class="card-title-group">
                                   <div class="card-title">
                                       <h6 class="title">Top Clubs</h6>
                                   </div>
                                   <div class="card-tools"> <a href="{{route('membershipclubs')}}" class="link">View
                                           All</a> </div>
                               </div>
                           </div>
                           @foreach ($topClubs as $club)
                           <div class="card-inner card-inner-md">
                               <div class="user-card">
                                   <div class="user-avatar " style="background-image: url({{$club->img}})
                                       ; background-position: center center; background-size: cover;
                                        height:50px; width:50px" >  </div>
                                   <div class="user-info"> <span class="lead-text">{{$club->title}} </span> <span
                                           class="sub-text">current Members {{$club->users_count}}</span> </div>
                                   <div class="user-action">
                                       <a href="{{url("admin/membershipclubs/new?step=1&id=$club->id")}}">
                                           <em class="icon ni ni-pen"></em>
                                       </a>
                                   </div>
                               </div>
                           </div>
                           @endforeach


                       </div>
                   </div><!-- .card -->
                </div>
                @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
      $(document).ready(function() {
    // Add click event for dropdown items
    $('.dropdown-item').on('click', function(e) {
        e.preventDefault(); // Prevent default action of <a> tag

        // Get selected duration from data attribute
        const selectedDuration = $(this).data('duration');

        // Update dropdown label to show selected duration
        $('#durationDropdown').text($(this).text());
        console.log(selectedDuration);
        membersrequest(selectedDuration);
        // Fetch data from API with the selected duration

    });

});
membersrequest('30days');
function membersrequest(selectedDuration){
    axios.get(`admin/memberships/club/members/?duration=${selectedDuration}`)
            .then(response => {
                // Process response data
                const clubNames = response.data.map(club => club.name);
                const userCounts = response.data.map(club => club.user_count);

                // Update chart with new data
                updateChart(clubNames, userCounts);
            })
            .catch(error => console.error('Error fetching data:', error));
}
// Function to update the chart with new data
function updateChart(clubNames, userCounts) {
    // Assuming a global chart variable, or create a new Chart.js instance
    const ctx = document.getElementById('membershipClubChart').getContext('2d');
    if (window.myChart) window.myChart.destroy(); // Destroy previous chart instance

    window.myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: clubNames,
            datasets: [{
                label: 'Number of Users',
                data: userCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

    </script>
@endsection
