@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/article.css') }}" />
<div class="container">
    <div class="row">
            <div class="row mx-auto">
                    <h3 class="title"> <b>Contact Us</b></h3>   
                    <p class="blog-body float-left">Your email address will not be published. Required fields are marked *</p>                                   
                    <form>                                     
                        <div class="form-groupform-group_view">
                          <label for="comment">Message</label>
                          <textarea class="form-control" id="comment" rows="3"></textarea>
                        </div>
                        <div class="form-group form-group_view mt-3">
                            <label for="name">Name *</label>
                            <input type="name" class="form-control" id="name">
                          </div>   
                          <div class="form-group form-group_view">
                              <label for="email">Eamil *</label>
                              <input type="email" class="form-control" id="email">
                            </div>                            
                              <a href="#" class="btn btn-block mt-5 mb-3">Submit</a>
                      </form>
                </div>
    </div>
</div>
@endsection