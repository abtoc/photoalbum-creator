<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    </head>
    <body id="page-top">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a href="#page-top" class="navbar-brand">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">ダッシュボード</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                        @if(Route::has('register'))
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">新規アカウント作成</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
        </nav>

        <header class="bg-primary bg-gradient text-white">
            <div class="container px-4 text-center">
                <h1 class="fw-bolder">フォトアルバム・クリエーターで、<br>あなたの作品をKindleで出版しよう！</h1>
                <p class="lead">新たなる写真集作成の革命が始まります。<br>フォトアルバム・クリエーターが、あなたが生成したAI写真をKindleで出版するサポートを提供します。</p>
            </div>
        </header>

        <section>
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>フォトアルバム・クリエーターについて</h2>
                        <p class="lead">
                            フォトアルバム・クリエーターは、「Google Colaboratory」で作成したAI美少女を、簡単にKindleの写真集を作成するお手伝いをします。
                        </p>
                        <p class="lead">
                            しかも、Webブラウザだけで作成が可能です。もはや専門知識や高価なハードウェア・ソフトウェアは必要ありません。
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>自動トリミングで最適なサイズに自動調整</h2>
                        <p class="lead">
                            自動トリミング機能によって、あなたの作品はKindle出版に最適なサイズに自動調整されます。
                            「Google Colaboratory」で生成に最適なサイズの2048x3072の写真を、Kindle出版に最適な1600x2560へと完璧にトリミング。
                        </p>
                        <p class="lead">
                            プロフェッショナルな品質を保ちながら、Kindleでの表示に最適化された美しい写真集を作成することができます。
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>お得な料金プラン</h2>
                        <p class="lead">
                            無料枠では1GBの容量が提供され、月額580円で100GBの容量をご利用いただけます。<br>
                            これならたくさんの作品を保管し、多彩な写真集を制作することができます。
                        </p>
                        <p class="lead">
                            決済は<a href="https://stripe.com/jp" class="link-dark" target="_blank">Stripe社</a>を通じて決済しますので、クレジットカードの情報等は本サービスで扱うことはありません。
                        </p>
                    </div>
                </div>
            </div>
        </section>

        @auth
        @else
            <section class="bg-light">
                <div class="container px-4">
                    <div class="row gx-4 justify-content-center">
                        <div class="col-lg-8">
                            <h2>はじめましょう</h2>
                            <p class="lead">
                                さあ、あなたの創造力を解放し、AI美少女写真集作成アプリで驚きと感動をもたらしましょう。今すぐ始めましょう！<br><br>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">無料ではじめる</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        @endauth

        <footer class="py-5 bg-dark">
            <div class="container px-4">
                <p class="m-0 text-center text-white">Copyright © PhotoAlbum-Creator 2023</p>
            </div>
        </footer>

        <script src="{{ mix('js/script.js') }}"></script>
    </body>
</html>
