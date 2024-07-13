<?php

/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu
{


	public static $navbarsideleft = array(
		array(
			'path' => 'home',
			'label' => 'Beranda',
			'icon' => '<i class="icon-home "></i>'
		),

		array(
			'path' => 'pendaftaran',
			'label' => 'Pelayanan',
			'icon' => '<i class="icon-book-open "></i>'
		),

		array(
			'path' => 'data_pasien',
			'label' => 'Data Pasien',
			'icon' => '<i class="icon-people "></i>'
		),

		array(
			'path' => 'pembayaran',
			'label' => 'Pembayaran',
			'icon' => '<i class="icon-basket-loaded "></i>'
		),

		array(
			'path' => 'menu5',
			'label' => 'Surat Keterangan',
			'icon' => '<i class="icon-envelope-letter "></i>',
			'submenu' => array(
				array(
					'path' => 'surat_keterangan_sehat',
					'label' => 'Surat Keterangan Sehat',
					'icon' => '<i class="icon-docs "></i>'
				),

				array(
					'path' => 'surat_keterangan_sakit',
					'label' => 'Surat Keterangan Sakit',
					'icon' => '<i class="icon-docs "></i>'
				),

				array(
					'path' => 'surat_keterangan_kematian',
					'label' => 'Surat Keterangan Kematian',
					'icon' => '<i class="icon-docs "></i>'
				)
			)
		),

		array(
			'path' => 'berobat',
			'label' => 'Data Tindakan',
			'icon' => '<i class="icon-heart "></i>'
		),

		array(
			'path' => 'user',
			'label' => 'Pengguna',
			'icon' => '<i class="icon-user "></i>'
		)
	);



	public static $jenis_kelamin = array(
		array(
			"value" => "laki-laki",
			"label" => "Laki-Laki",
		),
		array(
			"value" => "perempuan",
			"label" => "Perempuan",
		),
	);

	public static $agama = array(
		array(
			"value" => "islam",
			"label" => "Islam",
		),
		array(
			"value" => "kristen",
			"label" => "Kristen",
		),
		array(
			"value" => "katolik",
			"label" => "Katolik",
		),
		array(
			"value" => "hindu",
			"label" => "Hindu",
		),
		array(
			"value" => "buddha",
			"label" => "Buddha",
		),
		array(
			"value" => "konghuchu",
			"label" => "Konghuchu",
		),
		array(
			"value" => "lainnya",
			"label" => "Lainnya",
		),
	);

	public static $agama2 = array(
		array(
			"value" => "Islam",
			"label" => "Islam",
		),
		array(
			"value" => "Kristen",
			"label" => "Kristen",
		),
		array(
			"value" => "Katolik",
			"label" => "Katolik",
		),
		array(
			"value" => "Hindu",
			"label" => "Hindu",
		),
		array(
			"value" => "Buddha",
			"label" => "Buddha",
		),
		array(
			"value" => "Lainnya",
			"label" => "Lainnya",
		),
	);

	public static $kunjungan = array(
		array(
			"value" => "b",
			"label" => "B",
		),
		array(
			"value" => "l",
			"label" => "L",
		),
		array(
			"value" => "k",
			"label" => "K",
		),
		array(
			"value" => "kk",
			"label" => "KK",
		),
	);

	public static $umum_bpjs = array(
		array(
			"value" => "umum",
			"label" => "Umum",
		),
		array(
			"value" => "bpjs",
			"label" => "Bpjs",
		),
	);

	public static $poli = array(
		array(
			"value" => "poli umum",
			"label" => "POLI UMUM",
		),
		array(
			"value" => "poli gizi/imun",
			"label" => "POLI GIZI/IMUN",
		),
		array(
			"value" => "poli gigi",
			"label" => "POLI GIGI",
		),
		array(
			"value" => "kia/kb",
			"label" => "KIA/KB",
		),
		array(
			"value" => "kir kes",
			"label" => "KIR KES",
		),
	);
}
