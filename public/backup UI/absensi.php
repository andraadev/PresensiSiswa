@extends('layouts.secondary_layout')

@section('title')
	Tambah Data Absensi
@endsection

@section('heading')
	Tambah Data Absensi
	<div id="spacer" class="mb-3"></div>
@endsection
@section('content')
	{{-- <div class="row">
		<div class="col-sm-12 col-md-3 col-lg-3">
			{{-- <div class="card container" style="box-shadow: 2px 1px 1px 1px rgb(109, 109, 109)">
			<div class="card container shadow-md">
				<h4 class="fw-bolder">Achmad Fauzan Ibnu Sina</h4>
				<ul>
					<li>
						<input type="radio" name="" id="input-hadir" class="form-check-input">
						<label for="input-hadir">Hadir</label>
					</li>
					<li>
						<input type="radio" name="" id="input-sakit" class="form-check-input">
						<label for="input-sakit">Sakit</label>
					</li>
					<li>
						<input type="radio" name="" id="input-izin" class="form-check-input">
						<label for="input-izin">Izin</label>
					</li>
					<li>
						<input type="radio" name="" id="input-alpa" class="form-check-input">
						<label for="input-alpa">Alpa</label>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-12 col-md-3 col-lg-3">
			<div class="card container shadow-md">
				<h4 class="fw-bolder">Ade Aulia Rahman</h4>
				<ul>
					<li>
						<input type="radio" name="" id="input-hadir" class="form-check-input">
						<label for="input-hadir">Hadir</label>
					</li>
					<li>
						<input type="radio" name="" id="input-sakit" class="form-check-input">
						<label for="input-sakit">Sakit</label>
					</li>
					<li>
						<input type="radio" name="" id="input-izin" class="form-check-input">
						<label for="input-izin">Izin</label>
					</li>
					<li>
						<input type="radio" name="" id="input-alpa" class="form-check-input">
						<label for="input-alpa">Alpa</label>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-12 col-md-3 col-lg-3">
			<div class="card container shadow-md">
				<h4 class="fw-bolder">Adipati Abiyasa</h4>
				<ul>
					<li>
						<input type="radio" name="" id="input-hadir" class="form-check-input">
						<label for="input-hadir">Hadir</label>
					</li>
					<li>
						<input type="radio" name="" id="input-sakit" class="form-check-input">
						<label for="input-sakit">Sakit</label>
					</li>
					<li>
						<input type="radio" name="" id="input-izin" class="form-check-input">
						<label for="input-izin">Izin</label>
					</li>
					<li>
						<input type="radio" name="" id="input-alpa" class="form-check-input">
						<label for="input-alpa">Alpa</label>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-12 col-md-3 col-lg-3">
			<div class="card container shadow-md">
				<h4 class="fw-bolder">Amir Adib Alashfani</h4>
				<ul>
					<li>
						<input type="radio" name="" id="input-hadir" class="form-check-input">
						<label for="input-hadir">Hadir</label>
					</li>
					<li>
						<input type="radio" name="" id="input-sakit" class="form-check-input">
						<label for="input-sakit">Sakit</label>
					</li>
					<li>
						<input type="radio" name="" id="input-izin" class="form-check-input">
						<label for="input-izin">Izin</label>
					</li>
					<li>
						<input type="radio" name="" id="input-alpa" class="form-check-input">
						<label for="input-alpa">Alpa</label>
					</li>
				</ul>
			</div>
		</div>
	</div> --}}
	<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
		<!-- Siswa 1 -->
		<div class="col">
			<div class="card">
				<img src="https://placekitten.com/150/150" class="card-img-top rounded-img custom-img-width" alt="Foto John Doe">
				<div class="card-body text-center">
					<h5 class="card-title">John Doe</h5>

					<!-- Input Status Absensi -->
					<div class="mb-3">
						<label for="statusJohnDoe" class="form-label">Status Absensi:</label>
						<select class="form-select" id="statusJohnDoe">
							<option value="hadir">Hadir</option>
							<option value="izin">Izin</option>
							<option value="sakit">Sakit</option>
							<option value="alpa">Alpa</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<!-- Siswa 2 -->
		<div class="col">
			<div class="card">
				<img src="https://placekitten.com/150/150" class="card-img-top rounded-img custom-img-width" alt="Foto Jane Smith">
				<div class="card-body text-center">
					<h5 class="card-title">Jane Smith</h5>

					<!-- Input Status Absensi -->
					<div class="mb-3">
						<label for="statusJaneSmith" class="form-label">Status Absensi:</label>
						<select class="form-select" id="statusJaneSmith">
							<option value="hadir">Hadir</option>
							<option value="izin">Izin</option>
							<option value="sakit">Sakit</option>
							<option value="alpa">Alpa</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<!-- Siswa 3 -->
		<div class="col">
			<div class="card">
				<img src="https://placekitten.com/150/150" class="card-img-top rounded-img custom-img-width"
					alt="Foto David Johnson">
				<div class="card-body text-center">
					<h5 class="card-title">David Johnson</h5>

					<!-- Input Status Absensi -->
					<div class="mb-3">
						<label for="statusDavidJohnson" class="form-label">Status Absensi:</label>
						<select class="form-select" id="statusDavidJohnson">
							<option value="hadir">Hadir</option>
							<option value="izin">Izin</option>
							<option value="sakit">Sakit</option>
							<option value="alpa">Alpa</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<!-- Tambahkan card siswa lainnya sesuai kebutuhan -->
	</div>
@endsection

@extends('layouts.secondary_layout')

@section('title')
	Tambah Data Absensi
@endsection

@section('heading')
	Tambah Data Absensi
	<div id="spacer" class="mb-5"></div>
@endsection

@section('additional_css')
	<style>
		/* Menentukan tinggi dan lebar yang sama agar menjadi lingkaran */
		.rounded-circle-btn {
			width: 50px;
			height: 50px;
		}

		/* .btn-hover:hover {
														background-color: #007bff;
														color: #fff;
													} */
	</style>
@endsection
@section('content')
	<div class="alert alert-info" role="alert">
		H berarti Hadir, S berarti Sakit, I berarti Izin, dan A berarti Alpa/Tanpa Keterangan.
	</div>

	<div class="row">
		@forelse ($siswa as $data_siswa)
			<div class="col-md-4 col-sm-12">
				<div class="card shadow-md">
					<div class="card-body">
						<h3 class="text-center fw-bolder">{{ $data_siswa->nama_lengkap }}</h3>
						{{-- <section class="text-center mb-2">
							<input class="btn btn-primary rounded-circle rounded-circle-btn" type="radio" name="test" value="">H
							<label for="" class="btn btn-outline-success rounded-circle rounded-circle-btn text-center">
								<input type="hidden" name="" id="" hidden>H
							</label> 
							<form action="{{ route('absensi.store') }}" method="post">
								@csrf
								<button class="btn btn-success rounded-circle rounded-circle-btn" type="submit" name="Hadir"
									value="T">H</button>
								<button class="btn btn-danger rounded-circle rounded-circle-btn">S</button>
								<button class="btn btn-warning rounded-circle rounded-circle-btn">I</button>
								<button class="btn btn-secondary rounded-circle rounded-circle-btn">A</button>
							</form>

						</section> --}}
						{{-- <div class="btn-group" data-toggle="buttons">
							<label class="btn btn-primary">
								<input type="radio" name="options" id="option1"> Option 1
							</label>
							<label class="btn btn-primary">
								<input type="radio" name="options" id="option2"> Option 2
							</label>
							<label class="btn btn-primary">
								<input type="radio" name="options" id="option3"> Option 3
							</label>
						</div> --}}
						{{-- <div class="btn-group btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
							<label class="btn btn-outline-primary active" id="option1">
								<input type="radio" name="options" id="option1" autocomplete="off"> H
							</label>
							<label class="btn btn-outline-primary" for="option2">
								<input type="radio" name="options" id="option2" autocomplete="off" style="display:none"> I
							</label>
							<label class="btn btn-outline-primary">
								<input type="radio" name="options" id="option3" autocomplete="off" style="display:none"> S
							</label>
							<label class="btn btn-outline-primary">
								<input type="radio" name="options" id="option3" autocomplete="off" style="display:none"> A
							</label>
						</div> --}}
						{{-- <p class="d-inline-flex gap-1"> --}}
						{{-- <button type="button" class="btn" data-bs-toggle="button">Toggle button</button> --}}
						{{-- <button type="button" class="btn active" data-bs-toggle="button" aria-pressed="true">Active toggle button</button>
							<button type="button" class="btn" disabled data-bs-toggle="button">Disabled toggle button</button> --}}
						{{-- </p> --}}
						{{-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-secondary active" id="option1Label">
								<input type="radio" name="options" id="option1" checked style="visibility:hidden"> Active
							</label>
							<label class="btn btn-secondary" id="option2Label">
								<input type="radio" name="options" id="option2" style="visibility:hidden"> Radio
							</label>
							<label class="btn btn-secondary" id="option3Label">
								<input type="radio" name="options" id="option3" style="visibility:hidden"> Radio
							</label>
						</div> --}}
						<div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
							<label class="btn btn-outline-primary active" onclick="toggleActiveClass(this)">
								<input type="radio" name="options" id="option1" autocomplete="off" checked class="visually-hidden"> Hadir
							</label>
							<label class="btn btn-outline-secondary" onclick="toggleActiveClass(this)">
								<input type="radio" name="options" id="option2" autocomplete="off" class="visually-hidden"> Sakit
							</label>
							<label class="btn btn-outline-danger" onclick="toggleActiveClass(this)">
								<input type="radio" name="options" id="option3" autocomplete="off" class="visually-hidden"> Izin
							</label>
						</div>
					</div>

					<center><label for="" class="form-label">Keterangan...</label></center>
					<textarea name="" id="" cols="5" rows="2" class="form-control" style="resize: none"></textarea>
				</div>
			</div>
	</div>
@empty
	KOSONG PAKK
	@endforelse
	</div>
@endsection

@section('additional_js')
	<script>
		function toggleActiveClass(btn) {
			// Hapus class active dari semua button
			const buttons = document.querySelectorAll('.btn-group-toggle .btn');
			buttons.forEach((button) => {
				button.classList.remove('active');
			});

			// Tambahkan class active pada button yang diklik
			btn.classList.add('active');
		}
	</script>
@endsection
