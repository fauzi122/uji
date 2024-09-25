<!-- component -->
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<div
	class="absolute top-0 left-0 bg-gradient-to-br from-yellow-200 via-black to-blue-400 bottom-0 leading-5 h-full w-full overflow-hidden">
</div>
<div
	class="relative min-h-screen sm:flex sm:flex-row justify-center bg-transparent rounded-3xl shadow-xl">
	<div class="flex-col flex self-center lg:px-14 sm:max-w-4xl xl:max-w-md z-10">
		<div class="self-start hidden lg:flex flex-col text-gray-300">
			<h1 class="my-3 font-semibold text-4xl">MyBest</h1>
			<p class="pr-3 text-sm opacity-75"><b>Elearning Universitas Bina Sarana Informatika</b></p>
			<p>
				@php
				$hari_ini = date('Y-m-d');
				echo 'Hari ini. : '.dateIndonesia($hari_ini);
				echo '<br>IP : '.ambilIP();
				@endphp
			</p>
		</div>
	</div>
	<div class="flex justify-center self-center z-10">
		<div class="p-12 bg-white mx-auto rounded-3xl w-96">
			<div class="mb-7">
				<img src="{{ asset('assets/img/mybest_3.png') }}" alt="" height="70" class="me-1">
				<form method="POST" action="{{ route('login') }}">
					@csrf
			</div>
			<div class="space-y-6">
				<div class="">
					<input name="username" class="w-full text-sm text-gray-800 px-4 py-3 bg-gray-200 focus:bg-gray-200 border border-gray-700 rounded-lg focus:outline-none focus:border-purple-900" type="number" required placeholder="NIP Dosen / NIM Mahasiswa">
				</div>
				<div class="relative" x-data="{ show: true }">
					<input name="password" placeholder="Password" :type="show ? 'password' : 'text'" class="text-sm text-gray-800 px-4 py-3 rounded-lg w-full bg-gray-200 focus:bg-gray-200 border border-gray-900 focus:outline-none focus:border-purple-900">
					<div class="flex items-center absolute inset-y-0 right-0 mr-3 text-sm leading-5">
						<svg @click="show = !show" :class="{'hidden': !show, 'block':show }" class="h-4 text-purple-700" fill="none" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
							<path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
						</svg>
						<svg @click="show = !show" :class="{'block': !show, 'hidden':show }" class="h-4 text-purple-700" fill="none" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
							<path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"></path>
						</svg>
					</div>
				</div>
				<div class="space-y-6">
					<div class="mt-4">
						<label for="captcha_answer" class="block text-sm font-medium text-gray-700">Jawab Pertanyaan Berikut:</label>
						<div class="mt-1 w-full">
							<p id="captcha_question" class="text-gray-900">{{ $captcha['question'] }}</p>
							<input id="captcha_answer" class="w-full text-sm text-gray-800 px-4 py-3 bg-gray-200 border border-gray-700 rounded-lg focus:outline-none focus:bg-gray-200 focus:border-purple-900" type="number" name="captcha_answer" placeholder="Silakan jawab pertanyaan" required oninvalid="this.setCustomValidity('Silakan jawab pertanyaan.')" oninput="setCustomValidity('')"/>
							<p class="mt-2 text-sm text-red-600">{{ $errors->first('captcha_answer') }}</p>
						</div>
					</div>
				</div>
				<div class="flex items-center justify-between">
					<div class="text-sm ml-auto">
						{{-- <a href="#" class="text-purple-700 hover:text-purple-600">
							Forgot your password?</a> --}}
							@if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
					</div>
				</div>
				<div>
					<button type="submit" class="w-full flex justify-center bg-purple-900 hover:bg-purple-700 text-gray-100 p-3 rounded-lg tracking-wide font-semibold cursor-pointer transition ease-in duration-500">Sign in</button>
				</div>
				<div class="flex items-center justify-center space-x-2 my-5">
					<span class="text-blue-400 font-normal">Copyright © 2024</span>
				</div>
				<div class="flex justify-center gap-5 w-full"></div>
			</div>
			<div class="mt-7 text-center text-gray-300 text-xs">
				<span></span>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>
@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        generateCaptcha();

        document.getElementById('refresh_captcha').addEventListener('click', function() {
            generateCaptcha();
        });

        function generateCaptcha() {
            var num1 = Math.floor(Math.random() * 10);
            var num2 = Math.floor(Math.random() * 10);
            var answer = num1 + num2;

            var captchaQuestion = "Berapa hasil dari " + num1 + " + " + num2 + "?";
            document.getElementById('captcha_question').innerText = captchaQuestion;
            document.getElementById('captcha_answer').setAttribute('data-answer', answer);
        }
    });
</script>
@endpush
