@extends('admin.masteradmin')
@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        @if ( $errors->count() > 0 )

        @foreach( $errors->all() as $message )
        <p class="text-danger">{{ $message }}</p>
        @endforeach

        @endif
    </div>

    <!-- ============================================================== -->

    <div class="container">
        <div class="row">
            <div class="col-12">

                <!-- Form START -->
                <form action="{{ url('/admin/updateadmin') }}" method="post" class="mb-5">
                    @csrf
                    <div class="row mb-2 bg-light">
                        <!-- Contact detail -->
                        <div class="col-12 mb-md-0">
                            <div class="py-5 rounded">
                                <h4 class="mb-4 mt-0">Contact detail</h4>
                                <hr>
                                <div class="row">
                                    <!-- First Name -->


                                    <input type="hidden" class="form-control" id="id" name="id" placeholder=""
                                        aria-label="First name" value="{{ Auth::user()->id }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Name *</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="" aria-label="First name" value="{{ Auth::user()->name }}">
                                    </div>
                                    <!-- Mobile number -->
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile number *</label>
                                        <input type="text" class="form-control" id="mobileno" name="mobileno"
                                            placeholder="" aria-label="Phone number" value="{{ Auth::user()->mobileno }}">
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                    <!-- Skype -->
                                    <div class="col-md-6">
                                        <label class="form-label">Address *</label>
                                        <input type="text" class="form-control" placeholder="" id="address"
                                            name="address" aria-label="address" value="{{ Auth::user()->address }}">
                                    </div>
                                </div>
                            </div> <!-- Row END -->
                        </div>
                    </div>

                    <!-- Row END -->
                    <div class="col-12">

                        <button type="submit" class="btn btn-primary ">Save Changes</button>

                    </div>

                </form>

                <form action="{{ url('/admin/sociallinks') }} " method="post" class="mb-5">
                    @csrf

                    <!-- Social media detail -->
                    <div class="row mb-2 bg-light">
                        <div class="col-md-12">
                            <div class=" py-5 rounded">
                                <h4 class="mb-4 mt-0">Social media detail</h4>
                                <hr>
                                <div class="row p-3">
                                    <!-- Facebook -->
                                    <div class="col-md-6">
                                        <label class="form-label"><i
                                                class="fab fa-fw fa-facebook me-2 text-facebook"></i>Facebook *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Facebook"
                                            value="http://www.facebook.com">
                                    </div>
                                    <!-- Twitter -->
                                    <div class="col-md-6">
                                        <label class="form-label"><i
                                                class="fab fa-fw fa-twitter text-twitter me-2"></i>Twitter
                                            *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Twitter"
                                            value="http://www.twitter.com">
                                    </div>
                                    <!-- Linkedin -->
                                    <div class="col-md-6">
                                        <label class="form-label"><i
                                                class="fab fa-fw fa-linkedin-in text-linkedin me-2"></i>Linkedin *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Linkedin"
                                            value="http://www.linkedin.com">
                                    </div>
                                    <!-- Instragram -->
                                    <div class="col-md-6">
                                        <label class="form-label"><i
                                                class="fab fa-fw fa-instagram text-instagram me-2"></i>Instagram *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Instragram"
                                            value="http://www.instragram.com">
                                    </div>
                                    <!-- Dribble -->
                                    <div class="col-md-6">
                                        <label class="form-label"><i
                                                class="fas fa-fw fa-basketball-ball text-dribbble me-2"></i>Dribble
                                            *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Dribble"
                                            value="http://www.dribble.com">
                                    </div>
                                    <!-- Pinterest -->
                                    <div class="col-md-6">
                                        <label class="form-label"><i
                                                class="fab fa-fw fa-pinterest text-pinterest"></i>Pinterest
                                            *</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Pinterest"
                                            value="http://www.pinterest.com">
                                    </div>

                                </div> <!-- Row END -->
                            </div>
                        </div>
                    </div>

                    <!-- change password -->
                    <!-- button -->
                    <div class="col-12">

                        <button type="submit" class="btn btn-primary ">Save Changes</button>

                    </div>


                </form>

            </div>

        </div>
    </div>
@endsection
