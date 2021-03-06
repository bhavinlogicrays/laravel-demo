<!DOCTYPE html>
<html>
<head>
  <title>Laravel 8 File Upload Example</title>
 
  <meta name="csrf-token" content="{{ csrf_token() }}">
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
 
</head>
<body>
 
<div class="container mt-4">
 
  <h2 class="text-center">File Upload</h2>

  @if(Session::has('status'))
  <p class="alert">{{ Session::get('status') }}</p>
  @endif
 
      <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ url('store') }}" >

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                 
          <div class="row">
 
              <div class="col-md-12">
                  <div class="form-group">
                      <input type="file" name="file" placeholder="Choose file" id="file">
                        @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                  </div>
              </div>
                 
              <div class="col-md-12">
                  <button type="submit" class="btn btn-primary" id="submit">Submit</button>
              </div>
          </div>     
      </form>
</div>
 
</div>  
</body>
</html>