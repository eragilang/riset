<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <style>

            .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
            }

            @media (min-width: 768px) {
            .gradient-form {
            height: 100vh !important;
            }
            }
            @media (min-width: 769px) {
            .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
            }
            }
        </style>
    </head>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
                    <div class="text-center">
                        <img src="img/lotus.webp"
                            style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">Sekolah Kedokteran Hewan Biomedis</h4>
                        <h6 class="mt-1 mb-5 pb-1">Anatomi Veteriner Online Learning</h4>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                     
                        @if ($errors->get('email'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <div class="form-outline mb-4">
                            <input class="form-control" placeholder="contoh@email.com" required="required" value=" {{ old('email') }}"  autofocus="" name="email" type="email">
                        </div>

                        <div class="form-outline mb-4">
                            <input class="form-control" required="required"  autofocus="" name="password" type="password">
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log in</button>
                            <a class="text-muted" href="{{ route('password.request') }}">Lupa password?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Lebih dari Sekedar Belajar</h4>
                <p class="small mb-0">Anatomi Veteriner Learning Online merupakan sebuah sistem yang terdiri dari perangkat ajar
                  bagi siapapun yang ingin mempelajari anatomi tulang hewan sistem ini mendukung tampilan hewan 3D dan penggunaan Virtual Reality .</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</html>
