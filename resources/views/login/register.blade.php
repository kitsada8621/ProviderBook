@extends('login.app')
@section('title','สมัครใช้งาน')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
          <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
              <div class="col-lg-6 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                @if ($errors->any())
                    <div class="alert alert-danger rounded-0 m-0 ">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form class="pt-3" action="{{route('register.submit')}}" method="POST">
                      @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="position" id="position">
                        <option value="">Position</option>
                        <option value="1">Manager</option>
                        <option value="2">Admin</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Your Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Your Password">
                    </div>
                    <div class="mt-3">
                      <button type="submit" class="btn btn-block btn-primary font-weight-medium auth-form-btn">Submit</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                      Already have an account? <a href="{{route('login')}}" class="text-primary">Login</a>
                    </div>
                </form>
                    
                </div>
              </div>
              <div class="col-lg-6 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                
                <form class="pt-3" action="{{route('registerStudent.submit')}}" method="POST">
                      @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="std_id" id="std_id" placeholder="Your std_id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="std_name" id="std_name" placeholder="Your std_name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="std_email" id="std_email" placeholder="Your std_email">
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="major" id="major">
                        <option value="">major</option>
                        <option value="1">Computer Science</option>
                        <option value="2">Infomation tecnology</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" name="tel" id="tel" placeholder="Your tel">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="std_password" id="std_password" placeholder="Your password">
                    </div>
                    <div class="mt-3">
                      <button type="submit" class="btn btn-block btn-primary font-weight-medium auth-form-btn">Submit</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                      Already have an account? <a href="{{route('login')}}" class="text-primary">Login</a>
                    </div>
                </form>
                    
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
@push('script')
  <script>
      $(function(){
        
      });
  </script>
@endpush