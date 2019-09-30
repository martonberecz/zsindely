@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/article.css') }}" />
        <div class="row ml-5 mr-5">
          <div class="col col-md-7">
            <div class="row mb-5 mt-5">
              <div class="col col-md-12 mx-auto blog-index">
                <h5 class="date mb-3">APRIL 1, 2013</h5>
                <h3 class="title mb-5 mx-auto col-md-12">APRIL 2013 FREEBIE: DESKTOP CALENDAR WALLPAPER</h3>
                <img src="{{ asset('img/roofs/timber/timberRack.jpg') }}" class="img-fluid mx-auto d-block mb-4">
                <p class="blog-body">
                    This month’s freebie is a Desktop Wallpaper Calendar for April. Simply click on the monitor size below 
                    Â — there are four sizes to choose from – let me know if I didn’t get your monitor size made and I’ll 
                    add it! 1280 X 960 1600 X 900 1920 X 1200 1920 X 1440 2560 X […]
                </p>
                <h5 class="date mb-3 mt-4">BY: <a href="#"> KAREN </a>· FILED UNDER: <a href="#"> BLOG, FREEBIES </a></h5>
            </div>
            </div>
            <div class="row mt-5">
                <div class="col col-md-12 mx-auto blog-index mt-5">
                  <h5 class="date mb-3">MARCH 13, 2013</h5>
                  <h3 class="title mb-5 mx-auto col-md-12">GOOGLE READER SHUTTING DOWN JULY 1ST: HOW TO SAVE YOUR FEED SUBSCRIPTIONS SO YOU DON’T LOSE THEM</h3>
                  <img src="{{ asset('img/roofs/roofconst/flatRoofs.png') }}" class="img-fluid mx-auto d-block mb-4">
                  <p class="blog-body">
                      By now, you’ve probably heard the news that Google’s RSS Reader service is shutting down July 1st. You may have already even searched out some alternatives and found a few to try out before the “big day”. If you haven’t here are a few quick options for you: FeedReader Feedly NewsBlur Pulse Skimr Netvibes The […]
                  </p>
                  <h5 class="date mb-3 mt-4">BY: <a href="#"> KAREN </a>· FILED UNDER: <a href="#"> BLOG, FEATURED, TUTORIALS </a></h5>
              </div>
              </div>
              <div class="row mt-5">
                  <div class="col col-md-12 mx-auto blog-index mt-5">
                    <h5 class="date mb-3">MARCH 1, 2012</h5>
                    <a href="postView.html" class="title"><h3 class="title mb-5 mx-auto col-md-12">FACEBOOK’S TIMELINE & WHAT IT MEANS FOR YOUR BRAND</h3></a>
                    <img src="{{ asset('img/roofs/roofconst/waterSeal.jpg') }}" class="img-fluid mx-auto d-block mb-4">
                    <p class="blog-body">
                        The much-anticipated release of Timeline for Brands was rolled out today by Facebook and there are a few things you need to know if you are a Brand manager or Business owner. The newest feature has rolled out for preview across the network, and if you don’t upgrade before March 30, your page will be […]
                    </p>
                    <h5 class="date mb-3 mt-4">BY: <a href="#"> KAREN </a>· FILED UNDER: <a href="#"> BLOG, FACEBOOK </a></h5>
                </div>
                </div>                
  
          </div>
          <div class="col col-md-4 p-3 ml-4 side-bar mt-5">            
            <div class="row">
                <div class="col-sm-12">
                  <div class="card card_sidebar">
                    <div class="card-body">
                      <h2 class="card-title mb-5">Join our Newsletter</h2>
                      <form>
                          <div class="row mb-3">
                            <div class="col">
                              <input type="text" class="form-control" placeholder="First name">
                            </div>
                            <div class="col">
                              <input type="text" class="form-control" placeholder="Last name">
                            </div>
                          </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="E-Mail Address">
                        </div>
                      </form>
                      <a href="#" class="btn btn-block mt-4 mb-3">JOIN IT!</a>
                      <a href="#">Privacy Policy</a>
                    </div>
                  </div>
                </div>              
              </div>              
          </div>
        </div>     
  @endsection