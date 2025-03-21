<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta -->
	<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
	<meta name="author" content="ParkerThemes">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('assets/img/icon1.jfif') }}" />
	<!-- Title -->
	<title>My Best</title>


	<!-- *************
			************ Common Css Files *************
		************ -->
	<!-- Bootstrap css -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2.css') }}">

	<!-- Icomoon Font Icons css -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/style.css') }}">

	<!-- Main css -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<!-- Data Tables -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bs4-custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/datatables/buttons.bs.css') }}" />



	<!-- *************
			************ Vendor Css Files *************
		************ -->
	<!-- DateRange css -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/daterange/daterange.css') }}" />
	<style>
		.dijawab {
			background: #1980d4;
			color: #fff;
			padding: 5px 10px;
			border-radius: 3px;
		}

		.pagination>li>a,
		.pagination>li>span {
			width: 38px;
			text-align: center;
			margin: 3px;
		}

		.timer {
			border: solid thin #b9b2b2;
			padding: 5px 15px;
			font-size: 14pt;
			color: #fff;
			background: #291a71;
		}

		.soal {
			margin: 0 0 15px 0;
		}

		.box-footer {
			border-top: 1px solid #ebebeb !important;
		}

		.jawab {
			cursor: pointer;
			margin: 0 0 7px 0;
		}

		.pilihan p {
			margin: 0;
		}
	</style>
	<style>
		/* Styling untuk ikon chat */
		.chat-icon {
			position: fixed;
			bottom: 20px;
			right: 20px;
			cursor: pointer;
			z-index: 1000;
		}

		/* Ukuran ikon chat */
		.chat-icon img {
			width: 80px;
			transition: transform 0.3s ease-in-out;
			/* Efek animasi saat hover */
		}

		/* Efek animasi saat hover di ikon chat */
		.chat-icon img:hover {
			transform: scale(1.1);
			/* Membesar saat hover */
		}

		/* Styling untuk chat badge (jumlah pesan) */
		.chat-badge {
			position: absolute;
			top: -5px;
			right: -5px;
			background: red;
			color: white;
			font-size: 14px;
			font-weight: bold;
			width: 20px;
			height: 20px;
			text-align: center;
			line-height: 20px;
			border-radius: 50%;
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}

		/* Styling untuk chat box */
		.chat-box,
		.private-chat {
			position: fixed;
			bottom: 80px;
			right: 20px;
			width: 300px;
			background: white;
			border-radius: 10px;
			box-shadow: 0px 0px 10px gray;
			display: none;
			z-index: 1000;
		}

		/* Styling header chat box */
		.chat-header {
			background: #007bff;
			color: white;
			padding: 10px;
			display: flex;
			justify-content: space-between;
			border-radius: 10px 10px 0 0;
			/* Membulatkan sudut atas */
		}

		/* Styling body chat box */
		.chat-body {
			max-height: 300px;
			overflow-y: auto;
			padding: 10px;
		}

		/* Styling footer chat box */
		.chat-footer {
			padding: 10px;
			display: flex;
			align-items: center;
		}

		/* Styling input pesan */
		.chat-footer input {
			flex: 1;
			padding: 5px;
			border-radius: 5px;
			/* Membulatkan sudut input */
			border: 1px solid #ccc;
			margin-right: 10px;
			font-size: 14px;
		}

		/* Styling tombol kirim */
		.chat-footer button {
			background: #007bff;
			color: white;
			border: none;
			padding: 5px 15px;
			cursor: pointer;
			border-radius: 5px;
			/* Membulatkan sudut tombol */
			transition: background 0.3s ease;
		}

		/* Efek hover pada tombol kirim */
		.chat-footer button:hover {
			background: #0056b3;
		}

		/* Efek fokus pada input pesan */
		.chat-footer input:focus {
			outline: none;
			border-color: #007bff;
		}

		/* Styling untuk tombol Chat */
		.chat-button {
			background-color: #007bff;
			/* Warna biru tombol */
			color: white;
			/* Warna teks putih */
			padding: 6px 12px;
			/* Padding lebih kecil */
			border-radius: 4px;
			/* Sudut membulat lebih kecil */
			border: none;
			/* Menghilangkan border default */
			font-size: 12px;
			/* Ukuran font lebih kecil */
			cursor: pointer;
			/* Menunjukkan bahwa ini adalah elemen yang bisa diklik */
			transition: background-color 0.3s ease, transform 0.3s ease;
			/* Efek transisi saat hover */
			margin-top: 5px;
			/* Memberikan sedikit jarak atas */
		}

		/* Efek hover pada tombol Chat */
		.chat-button:hover {
			background-color: #0056b3;
			/* Ubah warna saat hover menjadi biru gelap */
			transform: translateY(-2px);
			/* Efek sedikit terangkat saat hover */
		}

		/* Efek focus saat tombol diklik */
		.chat-button:focus {
			outline: none;
			/* Menghilangkan border biru default saat klik */
			box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
			/* Memberikan efek glow biru */
		}
	</style>

</head>

<body>

	<!-- Loading starts -->
	{{-- <div id="loading-wrapper">
		<div class="spinner-border" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div> --}}
	<!-- Loading ends -->


	<!-- Page wrapper start -->
	<div class="page-wrapper pinned">

		<!-- Sidebar wrapper start -->
		<nav id="sidebar" class="sidebar-wrapper">

			<!-- Sidebar brand end  -->

			<!-- Sidebar content start -->
			@include('layouts.mhs.navigasi')
			<!-- Sidebar content end -->
		</nav>
		<!-- Sidebar wrapper end -->

		<!-- Page content start  -->
		<div class="page-content">

			<!-- Header start -->
			@include('layouts.mhs.header')
			<!-- Header end -->

			<!-- Page header start -->
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">Elearning Universitas Bina Sarana Informatika </li>
					{{-- <h5 class="btn btn-lg btn-info"> <b>*SEGERA LAKUKAN PERUBAHAN PASSWORD DEMI KEAMANAN AKUN ANDA.
							<a href="/user/profile">KLIK DI SINI</a></b></h5> --}}
					{{-- <li class="breadcrumb-item active">Account Settings</li> --}}
				</ol>

				<ul class="app-actions">
					<li>
						<a href="#" id="reportrange">
							<span class="range-text"></span>
							<i class="icon-chevron-down"></i>
						</a>
					</li>

				</ul>
			</div>
			<!-- Page header end -->

			<!-- Main container start -->
			<div class="main-container">
				@yield('content')
			</div>
			<!-- Main container end -->

		</div>
		<!-- Page content end -->

	</div>
	<!-- Page wrapper end -->
	<!-- Floating Chat Icon -->
	{{-- <div id="chat-icon" class="chat-icon">
		<div class="chat-user">
			<img src="{{ asset('assets/img/MyBest-chat.png') }}" alt="Chat">
			<span id="chat-user-count" class="chat-badge">0</span>
		</div>
	</div>

	<!-- Chat Box -->
	<!-- Chat Box -->
	<div id="chat-box" class="chat-box hidden">
		<div class="chat-header">
			<h5>Users Online</h5>
			<button id="close-chat" class="close">&times;</button>
		</div>
		<div class="chat-body">
			<ul id="chat-user-list"></ul> <!-- Daftar user online -->
		</div>
	</div>

	<!-- Private Chat Window -->
	<div id="private-chat" class="private-chat hidden">
		<div class="chat-header">
			<h5 id="private-chat-title">Chat</h5>
			<button id="close-private-chat" class="close">&times;</button>
		</div>
		<div class="chat-body" id="private-chat-messages"></div>
		<div class="chat-footer">
			<input type="text" id="private-message" placeholder="Ketik pesan...">
			<button onclick="sendPrivateMessage()">Kirim</button>
		</div>
	</div> --}}


	**************************-->
	<!-- Required jQuery first, then Bootstrap Bundle JS -->
	<script src="{{asset('/js/jquery-ui.min.js') }}"></script>
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets/js/moment.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/jquery.expander.js')}}"></script>


	<!-- *************
			************ Vendor Js Files *************
		************* -->
	<!-- Slimscroll JS -->
	<script src="{{asset('assets/vendor/slimscroll/slimscroll.min.js')}}"></script>
	<script src="{{asset('assets/vendor/slimscroll/custom-scrollbar.js')}}"></script>
	<!-- Daterange -->
	<script src="{{asset('assets/vendor/daterange/daterange.js')}}"></script>
	<script src="{{asset('assets/vendor/daterange/custom-daterange.js')}}"></script>
	<!-- Custom Data tables -->
	<script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/custom/fixedHeader.js')}}"></script>
	<!-- Data Tables -->
	<script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
	<!-- Download / CSV / Copy / Print -->
	<script src="{{asset('assets/vendor/datatables/buttons.min.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/jszip.min.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/pdfmake.min.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/vfs_fonts.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/html5.min.js')}}"></script>
	<script src="{{asset('assets/vendor/datatables/buttons.print.min.js')}}"></script>
	<!-- Main JS -->
	<script src="{{asset('assets/js/main.js')}}"></script>
	<script src="{{asset('assets/dist/sweetalert2.min.js')}}"></script>
	<script src="{{asset('assets/dist/script.js')}}"></script>
	<!-- Lobipanel -->
	<script>
		@if(isset($_GET['alert']))
		@if($_GET['alert'] == 'gagal')
		Swal.fire({
			title: 'Gagal Masuk Ke Laman Ujian!',
			text: 'Ganti Browser/Jaringan secara berkala',
			icon: 'error',
			confirmButtonText: 'Ok'
		});
		@endif
		@if($_GET['alert'] == 'hp')
		Swal.fire({
			title: 'Peringatan!',
			text: 'Halaman Ujian Tidak Bisa Dibuka Menggunakan Perangkat Hp',
			icon: 'warning',
			confirmButtonText: 'Ok'
		});
		@endif
		@if($_GET['alert'] == 'belumbayar')
		Swal.fire({
			title: 'Peringatan!',
			text: 'Anda Kurang Bayar',
			icon: 'warning',
			confirmButtonText: 'Ok'
		});
		@endif
		@endif
	</script>
	<!-- <script>
		document.addEventListener('DOMContentLoaded', function() {
			const appEnvironment = "{{ app()->environment() }}";
			const examSystemUrl = appEnvironment === 'production' ?
				'https://ujiankampusa.bsi.ac.id/authenticate' :
				'http://127.0.0.1:8001/authenticate';

			document.getElementById('triggerUjian').addEventListener('click', function(e) {
				e.preventDefault(); // Menghentikan aksi default link

				fetch('{{ route("Ujian.redirect") }}', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
						}
					})
					.then(response => response.json())
					.then(data => {
						if (data.token) {
							// Simpan token ke local storage
							localStorage.setItem('auth_token', data.token);
							// Redirect ke dashboard
							window.location.href = 'http://127.0.0.1:8001/dashboard';
						} else {
							console.error('Failed to retrieve token:', data.error);
							alert('Failed to retrieve token from the first application.');
						}
					})
					.catch(error => {
						console.error('Error fetching token:', error);
						alert('Error communicating with the first application.');
					});
			});
		});
	</script> -->
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	<script>
		let selectedUserId = null;

    document.getElementById("chat-icon").addEventListener("click", function () {
        let chatBox = document.getElementById("chat-box");
        chatBox.style.display = (chatBox.style.display === "block") ? "none" : "block"; // Toggle chat box
        fetchOnlineUsers(); // Saat ikon diklik, ambil daftar user online
    });

    document.getElementById("close-chat").addEventListener("click", function () {
        document.getElementById("chat-box").style.display = "none"; // Tutup daftar user online
    });

    document.getElementById("close-private-chat").addEventListener("click", function () {
        document.getElementById("private-chat").style.display = "none"; // Tutup private chat
    });

    // Ambil user online dari backend
    function fetchOnlineUsers() {
        fetch('/users-online')
            .then(response => response.json())
            .then(users => {
                console.log("Users Online:", users); // Debugging: cek apakah user online muncul

                let userList = document.getElementById("chat-user-list");
                if (!userList) {
                    console.error("chat-user-list tidak ditemukan!");
                    return;
                }

                userList.innerHTML = "";
                users.forEach(user => {
                    let li = document.createElement("li");
                    li.innerHTML = `<strong>${user.name}</strong>
                        <button class="chat-button" data-user-id="${user.id}" data-user-name="${user.name}">Chat</button>`;
                    userList.appendChild(li);
                });

                document.getElementById("chat-user-count").innerText = users.length;

                // Tambahkan event listener untuk semua tombol Chat setelah elemen dibuat
                document.querySelectorAll(".chat-button").forEach(button => {
                    button.addEventListener("click", function () {
                        let userId = this.getAttribute("data-user-id");
                        let userName = this.getAttribute("data-user-name");
                        openPrivateChat(userId, userName);
                    });
                });
            })
            .catch(error => console.error("Error fetching users:", error));
    }

    // Membuka private chat dengan user tertentu
    function openPrivateChat(userId, userName) {
        selectedUserId = userId;
        console.log(`Membuka chat dengan ${userName} (ID: ${userId})`);

        let chatBox = document.getElementById("private-chat");
        let chatTitle = document.getElementById("private-chat-title");

        if (!chatBox || !chatTitle) {
            console.error("private-chat atau private-chat-title tidak ditemukan!");
            return;
        }

        chatTitle.innerText = `Chat dengan ${userName}`;
        chatBox.style.display = "block"; // Tampilkan chat box
		fetchOldMessages(userId);
    }
	function fetchOldMessages(userId) {
    fetch(`/get-messages/${userId}`)
        .then(response => response.json())
        .then(messages => {
            let chatBox = document.getElementById("private-chat-messages");
            chatBox.innerHTML = ""; // Kosongkan chat lama sebelum menampilkan pesan baru

            messages.forEach(message => {
                let sender = (message.sender_id == "{{ Auth::id() }}") ? "Anda" : "User";
                chatBox.innerHTML += `<p><strong>${sender}:</strong> ${message.message}</p>
				<br><small>${message.created_at}</small><hr>`;
            });
        })
        .catch(error => console.error("Error fetching messages:", error));
}
    // Kirim pesan privat
    function sendPrivateMessage() {
        let message = document.getElementById("private-message").value;

        if (!selectedUserId) {
            alert("Pilih user terlebih dahulu!");
            return;
        }

        fetch('/send-private-message', {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ receiver_id: selectedUserId, message })
        })
            .then(response => response.json())
            .then(data => {
                let chatBox = document.getElementById("private-chat-messages");
                chatBox.innerHTML += `<p><strong>Anda:</strong> ${message}</p>`;
                document.getElementById("private-message").value = "";
            })
            .catch(error => console.error("Error sending message:", error));
    }

    // Realtime dengan Pusher untuk menerima pesan
    Echo.channel('private-chat')
        .listen('PrivateMessageSent', (e) => {
            console.log("Pesan diterima:", e.message);

            if (e.message.receiver_id == selectedUserId) {
                let chatBox = document.getElementById("private-chat-messages");
                chatBox.innerHTML += `<p><strong>${e.message.sender.name}:</strong> ${e.message.message}</p>`;
            }
        });

	</script>


	@stack('scripts')
</body>

</html>