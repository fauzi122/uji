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
		.chatx-icon {
			position: fixed;
			top: 50%;
			right: 0;
			transform: translateY(-50%);
			cursor: pointer;
			z-index: 1000;
		}

		/* Ukuran ikon chat */
		.chatx-icon img {
			width: 80px;
			transition: transform 0.3s ease-in-out;
			/* Efek animasi saat hover */
		}

		/* Efek animasi saat hover di ikon chat */
		.chatx-icon img:hover {
			transform: scale(1.1);
			/* Membesar saat hover */
		}

		/* Styling untuk chat badge (jumlah pesan) */
		.chatx-badge {
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
		.chatx-box,
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

		.chatx-box {
			position: fixed;
			bottom: 80px;
			right: 20px;
			width: 300px;
			height: 400px;
			background: white;
			border-radius: 10px;
			box-shadow: 0px 0px 10px gray;
			display: none;
			z-index: 1000;
			overflow: hidden;
		}

		.chatx-header {
			background: #007bff;
			color: white;
			padding: 10px;
			display: flex;
			justify-content: space-between;
			border-radius: 10px 10px 0 0;
		}

		/* HANYA bagian ini yang boleh scroll */
		.chatx-body {
			height: calc(100% - 50px);
			/* sisa tinggi dari header */
			overflow-y: auto;
			padding: 10px;
			box-sizing: border-box;
		}


		/* Styling footer chat box */
		.chatx-footer {
			padding: 10px;
			display: flex;
			align-items: center;
		}

		/* Styling input pesan */
		.chatx-footer input {
			flex: 1;
			padding: 5px;
			border-radius: 5px;
			/* Membulatkan sudut input */
			border: 1px solid #ccc;
			margin-right: 10px;
			font-size: 14px;
		}

		/* Styling tombol kirim */
		.chatx-footer button {
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
		.chatx-footer button:hover {
			background: #0056b3;
		}

		/* Efek fokus pada input pesan */
		.chatx-footer input:focus {
			outline: none;
			border-color: #007bff;
		}

		/* Styling untuk nama user yang bisa diklik */
		.chatx-user-link {
			cursor: pointer;
			color: #007bff;
			text-decoration: none;
			display: inline-block;
			padding: 5px;
			border-radius: 8px;
			transition: all 0.2s ease-in-out;
		}

		.chatx-user-link:hover {
			background-color: #f0f8ff;
		}

		.chatx-user-link.selected {
			background-color: #007bff;
			color: white;
			font-weight: bold;
			box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
		}


		.chatx-search-input {
			width: 100%;
			padding: 6px 10px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			font-size: 14px;
		}

		#chat-user-scroll {
			max-height: 300px;
			overflow-y: auto;
		}

		#private-chat-messages {
			height: 300px;
			overflow-y: auto;
			padding: 10px;
		}

		#private-message:disabled::placeholder {
			color: #888;
			font-style: italic;
		}

		.badge-unread {
			background-color: red;
			color: white;
			padding: 2px 6px;
			border-radius: 12px;
			font-size: 12px;
			margin-left: 5px;
			font-weight: bold;
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
	<div id="chat-icon" class="chatx-icon">
		<div class="chatx-user">
			<img src="{{ asset('assets/img/MyBest-chat.png') }}" alt="Chat">
			<span id="chat-user-count" class="chatx-badge">0</span>
		</div>
	</div>

	<!-- Chat Box -->
	<div id="chat-box" class="chatx-box">
		<div class="chatx-header">
			<h5>Users Online</h5>
			<button id="close-chat" class="close">&times;</button>
		</div>
		<div class="chatx-body" id="chat-user-scroll">
			<input type="text" id="search-user" placeholder="Cari user..." class="chatx-search-input">
			<ul id="chat-user-list"></ul>
		</div>
	</div>

	<!-- Private Chat Window -->
	<div id="private-chat" class="private-chat hidden">
		<div class="chatx-header">
			<h5 id="private-chat-title">Chat</h5>
			<button id="close-private-chat" class="close">&times;</button>
		</div>
		<div class="chatx-body" id="private-chat-messages"></div>
		<div class="chatx-footer">
			<input type="text" id="private-message" placeholder="Ketik pesan...">
			<button onclick="sendPrivateMessage()">Kirim</button>
		</div>
	</div>


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
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	<script>
		let selectedUserId = null;

		document.getElementById("chat-icon").addEventListener("click", function () {
			let chatBox = document.getElementById("chat-box");
			chatBox.style.display = (chatBox.style.display === "block") ? "none" : "block";

			if (chatBox.style.display === "block") {
				offset = 0;
				allLoaded = false;
				fetchOnlineUsers(true); // reset data saat buka chat box
			}
		});

		document.getElementById("close-chat").addEventListener("click", function() {
			document.getElementById("chat-box").style.display = "none"; // Tutup daftar user online
		});

		document.getElementById("close-private-chat").addEventListener("click", function() {
			document.getElementById("private-chat").style.display = "none"; // Tutup private chat
		});
		function toTitleCase(str) {
			return str.toLowerCase().split(' ').map(word => 
				word.charAt(0).toUpperCase() + word.slice(1)
			).join(' ');
		}
		// Ambil user online dari backend
		let offset = 0;
		const limit = 20;
		let isLoading = false;
		let allLoaded = false;
		let searchKeyword = "";
		let isSearching = false;
		let lastSendTime = 0;
		const sendCooldown = 10; // dalam detik
		let privateMessageOffset = 0;
		const privateMessageLimit = 20;
		let privateLoading = false;
		let allPrivateLoaded = false;



		function fetchOnlineUsers(reset = false) {
			if (isLoading || (!isSearching && allLoaded)) return;

			if (reset) {
				offset = 0;
				allLoaded = false;
				document.getElementById("chat-user-list").innerHTML = "";
			}

			isLoading = true;

			let url = isSearching
				? `/users-online?search=${encodeURIComponent(searchKeyword)}`
				: `/users-online?limit=${limit}&offset=${offset}`;

			fetch(url)
				.then(response => response.json())
				.then(response => {
					const users = response.users || response; // fallback untuk non-paginated response
					const total = response.total || users.length;

					// ✅ Update badge total user online
					document.getElementById("chat-user-count").innerText = total;

					if (!isSearching && users.length < limit) {
						allLoaded = true;
					}

					const userList = document.getElementById("chat-user-list");

					users.forEach(user => {
						let li = document.createElement("li");
						let name = toTitleCase(user.name);
						let kode = user.kode;
						let unread = user.unread_count || 0;
						li.innerHTML = `
							<span class="chatx-user-link" data-user-id="${user.id}" data-user-name="${name}">
								${name} (${kode}) 
								${unread > 0 ? `<span class="badge-unread">${unread}</span>` : ''}
							</span>
						`;
						userList.appendChild(li);
					});

					// Bind klik ke setiap user
					document.querySelectorAll(".chatx-user-link").forEach(link => {
						link.addEventListener("click", function () {
							let userId = this.getAttribute("data-user-id");
							let userName = this.getAttribute("data-user-name");
							document.querySelectorAll(".chatx-user-link").forEach(item => {
								item.classList.remove("selected");
							});
							this.classList.add("selected");
							openPrivateChat(userId, userName);
						});
					});

					if (!isSearching) {
						offset += limit;
					}

					isLoading = false;
				})
				.catch(error => {
					console.error("Error fetching users:", error);
					isLoading = false;
				});
		}


		// Membuka private chat dengan user tertentu
		function openPrivateChat(userId, userName) {
			selectedUserId = userId;
			privateMessageOffset = 0;
			allPrivateLoaded = false;

			let chatBox = document.getElementById("private-chat");
			let chatTitle = document.getElementById("private-chat-title");
			let chatMessages = document.getElementById("private-chat-messages");

			// ✅ Benar-benar hapus isi chat sebelumnya
			if (chatMessages) {
				chatMessages.innerHTML = '';
			}

			// Tampilkan nama user tujuan
			if (chatTitle) {
				chatTitle.innerText = `Chat dengan ${userName}`;
			}

			// Tampilkan chat box
			chatBox.style.display = "block";

			// Ambil pesan untuk user baru
			fetchOldMessages(userId, true);
		}


		function fetchOldMessages(userId, isReset = true) {
			if (privateLoading || allPrivateLoaded) return;
			privateLoading = true;

			if (isReset) {
				privateMessageOffset = 0;
				allPrivateLoaded = false;
			}

			const currentUserLock = selectedUserId;

			fetch(`/get-messages/${userId}?offset=${privateMessageOffset}&limit=${privateMessageLimit}`)
				.then(response => response.json())
				.then(messages => {
					// ✅ Cek: apakah masih chat dengan user yang sama?	
					if (currentUserLock !== selectedUserId) {
						console.warn("User berubah saat pesan datang, abaikan.");
						privateLoading = false;
						return;
					}

					if (messages.length < privateMessageLimit) {
						allPrivateLoaded = true;
					}

					const chatBox = document.getElementById("private-chat-messages");

					messages.forEach(message => {
						let sender = (message.sender_id == "{{ Auth::id() }}") ? "Anda" : message.sender_name;
						const p = document.createElement("p");
						p.innerHTML = `<strong>${sender}:</strong> ${escapeHtml(message.message)}<br><small>${message.created_at}</small><hr>`;
						chatBox.appendChild(p); // atau prepend jika kamu pakai scroll atas
					});

					privateMessageOffset += privateMessageLimit;
					privateLoading = false;

					// Scroll ke bawah setelah pesan masuk (opsional)
					if (isReset) {
						chatBox.scrollTop = chatBox.scrollHeight;
					}
				})
				.catch(error => {
					console.error("Error fetching messages:", error);
					privateLoading = false;
				});
		}


		// Kirim pesan privat
		function sendPrivateMessage() {
			let input = document.getElementById("private-message");
			let message = escapeHtml(input.value.trim());
			const kirimButton = document.querySelector('#private-chat .chatx-footer button');

			if (!selectedUserId) {
				alert("Pilih user terlebih dahulu!");
				return;
			}

			if (message === "") {
				alert("Pesan tidak boleh kosong!");
				return;
			}

			// Cegah spam: disable input & tombol
			const cooldown = 10; // detik
			let remaining = cooldown;

			input.disabled = true;
			kirimButton.disabled = true;
			input.value = "";
			input.placeholder = `Tunggu ${remaining} detik...`;

			const countdownInterval = setInterval(() => {
				remaining--;
				if (remaining > 0) {
					input.placeholder = `Tunggu ${remaining} detik...`;
				} else {
					clearInterval(countdownInterval);
					input.disabled = false;
					kirimButton.disabled = false;
					input.placeholder = "Ketik pesan...";
				}
			}, 1000);

			// Kirim pesan ke server
			fetch('/send-private-message', {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
				},
				body: JSON.stringify({
					receiver_id: selectedUserId,
					message
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					alert(data.error); // Tampilkan pesan error
				} else {
					let chatBox = document.getElementById("private-chat-messages");
					chatBox.innerHTML += `<p><strong>Anda:</strong> ${message}</p>`;
					chatBox.scrollTop = chatBox.scrollHeight;
				}
			})
			.catch(error => {
				console.error("Error sending message:", error);
			});
		}


		document.getElementById("search-user").addEventListener("keyup", function () {
			searchKeyword = this.value.trim().toLowerCase();
			isSearching = searchKeyword !== ""; // True kalau ada keyword pencarian

			offset = 0;
			allLoaded = false;
			fetchOnlineUsers(true);
		});

		document.getElementById("chat-user-scroll").addEventListener("scroll", function () {
			const scrollTop = this.scrollTop;
			const scrollHeight = this.scrollHeight;
			const offsetHeight = this.offsetHeight;

			if (scrollTop + offsetHeight >= scrollHeight - 10) {
				fetchOnlineUsers();
			}
		});
		function escapeHtml(text) {
			const div = document.createElement("div");
			div.innerText = text;
			return div.innerHTML;
		}

		// Realtime dengan Pusher untuk menerima pesan
		Echo.channel('private-chat')
			.listen('PrivateMessageSent', (e) => {
				console.log("Pesan diterima:", e.message);

				if (e.message.receiver_id == selectedUserId) {
					let chatBox = document.getElementById("private-chat-messages");

					// Membuat elemen baru untuk pesan
					const p = document.createElement("p");
					const sender = document.createElement("strong");
					sender.textContent = `${e.message.sender.name}:`;

					const messageText = document.createElement("span");
					messageText.textContent = e.message.message;

					p.appendChild(sender);
					p.appendChild(messageText);
					chatBox.appendChild(p);
				}
			});

	</script>


	@stack('scripts')
</body>

</html>