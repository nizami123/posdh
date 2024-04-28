<div class="row">
	<div class="col-lg-12">
		<div class="row">
		<div class="col-md-12">
			<div class="card card-primary mb-3">
				<div class="card-body">
					<p class="mb-1">Saldo Awal</p>
					<h4><?= nf($uang_kasir) ?></h4>
					<div class="card-icon d-flex">
						<i class="fa fa-money-bill-alt"></i>
					</div>
					<!-- Button to open modal -->
					<?php if (nf($uang_kasir) > 0 && $status == 0){ ?>
					<button type="button" class="btn btn-primary mt-3" onclick="window.location.href='<?php echo site_url('dashboard/tutup_toko'); ?>'">
						Tutup Toko
					</button>
					<?php }elseif (nf($uang_kasir) == 0){ ?>
					<button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#saldoModal">
						Buka Toko
					</button>
					<?php } ?>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="saldoModal" tabindex="-1" role="dialog" aria-labelledby="saldoModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="saldoModalLabel">Input Saldo Toko</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" action="<?php echo site_url('dashboard/simpan_saldo'); ?>">
					<div class="modal-body">
						<div class="form-group">
							<label for="saldoInput">Saldo:</label>
							<input type="text" class="form-control" id="saldoInput" name="saldo" placeholder="Masukkan saldo">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
					</form>
				</div>
			</div>
		</div>

			<div class="col-md-6">
				<a class="card card-primary mb-3">
					<div class="card-body">
						<p class="mb-1">Pemasukan hari ini</p>
						<h4><?= nf($pemasukan_today) ?></h4>
						<div class="card-icon d-flex">
							<i class="fa fa-money-bill-alt"></i>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<a class="card card-primary mb-3">
					<div class="card-body">
						<p class="mb-1">Uang Kasir</p>
						<h4><?= nf($pemasukan_today + $uang_kasir) ?></h4>
						<div class="card-icon d-flex">
							<i class="fa fa-money-bill-alt"></i>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<a href="<?= site_url('penjualan/riwayat') ?>" class="card card-danger">
					<div class="card-body">
						<p class="mb-1">Penjualan hari ini</p>
						<h4><?= $total_jual ?></h4>
						<div class="card-icon d-flex">
							<i class="fa fa-shopping-basket"></i>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<a href="<?= site_url('penjualan/riwayat') ?>" class="card card-danger">
					<div class="card-body">
						<p class="mb-1">Total Saldo</p>
						<h4><?= nf($pemasukan_today + $uang_kasir) ?></h4>
						<div class="card-icon d-flex">
							<i class="fa fa-shopping-basket"></i>
						</div>
					</div>
				</a>
			</div>
			
			<?php if(admin()->level != 'Admin' ) : ?>
				<div class="col-md-12">
					<div class="card pt-2">
						<div class="card-header">
							<h2 class="mb-0 text-primary">Riwayat</h2>
							<small>Riwayat Penjualan</small>
						</div>
						<div class="card-body">
							<?php if($data_jual) : ?>
								<?php if(admin()->level == 'Kasir') : ?>
									<div class="alert alert-primary mb-4">
										<span class="badge bg-white text-primary mr-1"><?= $total_jual ?></span> Transaksi penjualan hari ini
									</div>
								<?php endif ?>

								<ul class="timeline">
									<?php 
										foreach($data_jual as $jual) : 
											$nama_plg   = $jual->id_plg ? $jual->nama_plg : 'Umum';
											$jml_tr		= $this->jual->cek_jml_jual($jual->kode_penjualan);
									?>
										<li>
											<div class="time">
												<h6 class="text-right">
													<b class="text-primary">
														<?= date('G:i', strtotime($jual->tgl_transaksi)) ?>
													</b>
													<br>
													<small class="text-muted">
														<?= date('d/m/Y', strtotime($jual->tgl_transaksi)) ?>
													</small> 
												</h6>
											</div>
											<div class="actv">
												<h6>
													<strong>
														<?= $nama_plg ?>
													</strong>
												</h6>
												<p>
													
													<span>
														<?= $jual->kode_penjualan ?>
													</span>
													<span class="mx-2"> | </span>
													<span><?= $jml_tr ?> Barang</span>
													<?php  if(admin()->level == 'Owner') : ?>
														<br>
														<span>Kasir: </span>
														<strong>
															<?= $jual->nama_admin ?>
														</strong>
													<?php endif ?>
												</p>
											</div>
										</li>
									<?php endforeach ?>
								</ul>
								
							<?php else: ?>
								<div class="alert alert-secondary text-center">
									Belum ada transaksi penjualan
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>        