<?php

namespace Database\Seeders;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // ── Users ──
        $admin = User::updateOrCreate(
            ['email' => 'admin@library.test'],
            ['name' => 'Administrator', 'password' => Hash::make('password')]
        );
        $admin->assignRole('Admin');

        $petugas = User::updateOrCreate(
            ['email' => 'petugas@library.test'],
            ['name' => 'Petugas Perpustakaan', 'password' => Hash::make('password')]
        );
        $petugas->assignRole('Petugas');

        // ── Kategori (dari GENRE buku .sql) ──
        $novel      = Category::updateOrCreate(['name' => 'Novel'],        ['description' => 'Koleksi karya fiksi dan sastra populer.']);
        $sastra     = Category::updateOrCreate(['name' => 'Sastra'],       ['description' => 'Karya sastra klasik dan modern.']);
        $pengembangan = Category::updateOrCreate(['name' => 'Pengembangan Diri'], ['description' => 'Buku motivasi dan pengembangan diri.']);
        $sejarah    = Category::updateOrCreate(['name' => 'Sejarah'],      ['description' => 'Buku sejarah dan peradaban.']);
        $filsafat   = Category::updateOrCreate(['name' => 'Filsafat'],     ['description' => 'Buku filsafat dan pemikiran kritis.']);
        $biografi   = Category::updateOrCreate(['name' => 'Biografi'],     ['description' => 'Kisah nyata tokoh inspiratif.']);
        $fantasi    = Category::updateOrCreate(['name' => 'Fantasi'],      ['description' => 'Karya fiksi fantasi dan petualangan.']);
        $keuangan   = Category::updateOrCreate(['name' => 'Keuangan'],     ['description' => 'Buku keuangan, investasi, dan bisnis.']);
        $teknologi  = Category::updateOrCreate(['name' => 'Teknologi'],    ['description' => 'Buku pemrograman dan teknologi digital.']);
        $psikologi  = Category::updateOrCreate(['name' => 'Psikologi'],    ['description' => 'Buku psikologi dan perilaku manusia.']);
        $romantis   = Category::updateOrCreate(['name' => 'Romantis'],     ['description' => 'Karya fiksi bertema percintaan.']);
        $bisnis     = Category::updateOrCreate(['name' => 'Bisnis'],       ['description' => 'Buku bisnis, startup, dan kewirausahaan.']);
        $islami     = Category::updateOrCreate(['name' => 'Islami'],       ['description' => 'Buku bertemakan keislaman.']);
        $hukum      = Category::updateOrCreate(['name' => 'Hukum'],        ['description' => 'Buku ilmu hukum dan perundangan.']);
        $akademik   = Category::updateOrCreate(['name' => 'Akademik'],     ['description' => 'Buku teks dan referensi akademik.']);

        // ── Buku (dari tabel buku .sql) ──
        $books = collect([
            Book::updateOrCreate(['title' => 'Laskar Pelangi'],
                ['category_id' => $novel->id, 'author' => 'Andrea Hirata', 'publisher' => 'Bentang Pustaka', 'publication_year' => 2005, 'stock' => 5, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Bumi Manusia'],
                ['category_id' => $sastra->id, 'author' => 'Pramoedya Ananta Toer', 'publisher' => 'Hasta Mitra', 'publication_year' => 1980, 'stock' => 3, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Pulang'],
                ['category_id' => $novel->id, 'author' => 'Tere Liye', 'publisher' => 'Republika', 'publication_year' => 2015, 'stock' => 4, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Atomic Habits'],
                ['category_id' => $pengembangan->id, 'author' => 'James Clear', 'publisher' => 'Gramedia', 'publication_year' => 2020, 'stock' => 6, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Sapiens'],
                ['category_id' => $sejarah->id, 'author' => 'Yuval Noah Harari', 'publisher' => 'KPG', 'publication_year' => 2017, 'stock' => 2, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Filosofi Teras'],
                ['category_id' => $filsafat->id, 'author' => 'Henry Manampiring', 'publisher' => 'Kompas', 'publication_year' => 2018, 'stock' => 4, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Si Anak Kampung'],
                ['category_id' => $biografi->id, 'author' => 'Masri Sareb Putra', 'publisher' => 'Indiva', 'publication_year' => 2019, 'stock' => 3, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Harry Potter dan Batu Bertuah'],
                ['category_id' => $fantasi->id, 'author' => 'J.K. Rowling', 'publisher' => 'Gramedia', 'publication_year' => 2000, 'stock' => 5, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Rich Dad Poor Dad'],
                ['category_id' => $keuangan->id, 'author' => 'Robert T. Kiyosaki', 'publisher' => 'Gramedia', 'publication_year' => 2016, 'stock' => 4, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'The Alchemist'],
                ['category_id' => $novel->id, 'author' => 'Paulo Coelho', 'publisher' => 'Gramedia', 'publication_year' => 2010, 'stock' => 3, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Negeri 5 Menara'],
                ['category_id' => $novel->id, 'author' => 'Ahmad Fuadi', 'publisher' => 'Gramedia', 'publication_year' => 2009, 'stock' => 5, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Seri Belajar Python'],
                ['category_id' => $teknologi->id, 'author' => 'Fahmizal Usman', 'publisher' => 'Elex Media', 'publication_year' => 2021, 'stock' => 4, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Thinking, Fast and Slow'],
                ['category_id' => $psikologi->id, 'author' => 'Daniel Kahneman', 'publisher' => 'Gramedia', 'publication_year' => 2018, 'stock' => 2, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Dilan: Dia adalah Dilanku'],
                ['category_id' => $romantis->id, 'author' => 'Pidi Baiq', 'publisher' => 'Pastel Books', 'publication_year' => 2014, 'stock' => 6, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Zero to One'],
                ['category_id' => $bisnis->id, 'author' => 'Peter Thiel', 'publisher' => 'Gramedia', 'publication_year' => 2015, 'stock' => 3, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Ketika Mas Gagah Pergi'],
                ['category_id' => $islami->id, 'author' => 'Helvy Tiana Rosa', 'publisher' => 'Sirius Popstar', 'publication_year' => 2013, 'stock' => 4, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Pengantar Ilmu Hukum'],
                ['category_id' => $hukum->id, 'author' => 'Sudikno Mertokusumo', 'publisher' => 'Liberty', 'publication_year' => 2011, 'stock' => 2, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Matematika Diskrit'],
                ['category_id' => $akademik->id, 'author' => 'Rinaldi Munir', 'publisher' => 'Informatika', 'publication_year' => 2020, 'stock' => 3, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'Ikigai'],
                ['category_id' => $pengembangan->id, 'author' => 'Hector Garcia', 'publisher' => 'Gramedia', 'publication_year' => 2019, 'stock' => 5, 'cover_image' => null]),
            Book::updateOrCreate(['title' => 'The Psychology of Money'],
                ['category_id' => $keuangan->id, 'author' => 'Morgan Housel', 'publisher' => 'Gramedia', 'publication_year' => 2022, 'stock' => 4, 'cover_image' => null]),
        ]);

        // ── Anggota (dari tabel anggota .sql) ──
        $members = collect([
            Member::updateOrCreate(['member_code' => 'KA001'], ['name' => 'Andi Pratama',     'address' => 'Jl. Merdeka No. 12, Jakarta',          'phone' => '081234567890']),
            Member::updateOrCreate(['member_code' => 'KA002'], ['name' => 'Siti Rahayu',      'address' => 'Jl. Sudirman No. 5, Bandung',           'phone' => '082345678901']),
            Member::updateOrCreate(['member_code' => 'KA003'], ['name' => 'Budi Santoso',     'address' => 'Jl. Imam Bonjol No. 8, Surabaya',       'phone' => '083456789012']),
            Member::updateOrCreate(['member_code' => 'KA004'], ['name' => 'Dewi Anggraini',   'address' => 'Jl. Ahmad Yani No. 22, Medan',          'phone' => '084567890123']),
            Member::updateOrCreate(['member_code' => 'KA005'], ['name' => 'Riko Firmansyah',  'address' => 'Jl. Diponegoro No. 3, Yogyakarta',      'phone' => '085678901234']),
            Member::updateOrCreate(['member_code' => 'KA006'], ['name' => 'Laila Putri',      'address' => 'Jl. Gajah Mada No. 17, Semarang',       'phone' => '086789012345']),
            Member::updateOrCreate(['member_code' => 'KA007'], ['name' => 'Hendra Wijaya',    'address' => 'Jl. Pemuda No. 9, Makassar',            'phone' => '087890123456']),
            Member::updateOrCreate(['member_code' => 'KA008'], ['name' => 'Nurul Hidayah',    'address' => 'Jl. Pahlawan No. 45, Palembang',        'phone' => '088901234567']),
            Member::updateOrCreate(['member_code' => 'KA009'], ['name' => 'Fajar Setiawan',   'address' => 'Jl. Raya No. 33, Bogor',                'phone' => '089012345678']),
            Member::updateOrCreate(['member_code' => 'KA010'], ['name' => 'Rina Maharani',    'address' => 'Jl. Kartini No. 7, Malang',             'phone' => '081123456789']),
            Member::updateOrCreate(['member_code' => 'KA011'], ['name' => 'Doni Kurniawan',   'address' => 'Jl. Kebon Jeruk No. 28, Jakarta',       'phone' => '082234567890']),
            Member::updateOrCreate(['member_code' => 'KA012'], ['name' => 'Mega Wulandari',   'address' => 'Jl. Teuku Umar No. 11, Denpasar',       'phone' => '083345678901']),
            Member::updateOrCreate(['member_code' => 'KA013'], ['name' => 'Agus Salim',       'address' => 'Jl. Veteran No. 6, Balikpapan',         'phone' => '084456789012']),
            Member::updateOrCreate(['member_code' => 'KA014'], ['name' => 'Yuni Astuti',      'address' => 'Jl. Pattimura No. 14, Manado',          'phone' => '085567890123']),
            Member::updateOrCreate(['member_code' => 'KA015'], ['name' => 'Rizal Hakim',      'address' => 'Jl. Sultan Agung No. 19, Pontianak',    'phone' => '086678901234']),
            Member::updateOrCreate(['member_code' => 'KA016'], ['name' => 'Fitri Ramadhani',  'address' => 'Jl. Sisingamangaraja No. 2, Jambi',     'phone' => '087789012345']),
            Member::updateOrCreate(['member_code' => 'KA017'], ['name' => 'Wahyu Nugroho',    'address' => 'Jl. Gatot Subroto No. 31, Solo',        'phone' => '088890123456']),
            Member::updateOrCreate(['member_code' => 'KA018'], ['name' => 'Indah Permata',    'address' => 'Jl. Hayam Wuruk No. 56, Surakarta',     'phone' => '089901234567']),
            Member::updateOrCreate(['member_code' => 'KA019'], ['name' => 'Bagas Prasetyo',   'address' => 'Jl. Ciledug Raya No. 77, Tangerang',    'phone' => '081012345678']),
            Member::updateOrCreate(['member_code' => 'KA020'], ['name' => 'Cantika Dewi',     'address' => 'Jl. Pajajaran No. 4, Bandung',          'phone' => '082123456789']),
        ]);

        // ── Favorit (Many-to-Many) ──
        $members[0]->favoriteBooks()->syncWithoutDetaching([$books[0]->id, $books[2]->id]);
        $members[1]->favoriteBooks()->syncWithoutDetaching([$books[1]->id, $books[9]->id]);
        $members[2]->favoriteBooks()->syncWithoutDetaching([$books[3]->id]);
        $members[4]->favoriteBooks()->syncWithoutDetaching([$books[7]->id, $books[10]->id]);
        $members[6]->favoriteBooks()->syncWithoutDetaching([$books[4]->id]);

        // ── Peminjaman ──
        $loan1 = Loan::withoutEvents(fn () => Loan::updateOrCreate(
            ['member_id' => $members[0]->id, 'loan_date' => now()->subDays(5)->toDateString()],
            ['due_date' => now()->addDays(2)->toDateString(), 'status' => LoanStatus::Borrowed, 'returned_at' => null]
        ));
        $loan1->details()->updateOrCreate(['book_id' => $books[0]->id], ['quantity' => 1]);
        $loan1->details()->updateOrCreate(['book_id' => $books[3]->id], ['quantity' => 1]);

        $loan2 = Loan::withoutEvents(fn () => Loan::updateOrCreate(
            ['member_id' => $members[1]->id, 'loan_date' => now()->subDays(12)->toDateString()],
            ['due_date' => now()->subDays(5)->toDateString(), 'status' => LoanStatus::Returned, 'returned_at' => now()->subDays(4)]
        ));
        $loan2->details()->updateOrCreate(['book_id' => $books[1]->id], ['quantity' => 1]);

        $loan3 = Loan::withoutEvents(fn () => Loan::updateOrCreate(
            ['member_id' => $members[2]->id, 'loan_date' => now()->subDays(8)->toDateString()],
            ['due_date' => now()->subDays(1)->toDateString(), 'status' => LoanStatus::Late, 'returned_at' => null]
        ));
        $loan3->details()->updateOrCreate(['book_id' => $books[7]->id], ['quantity' => 1]);
        $loan3->details()->updateOrCreate(['book_id' => $books[11]->id], ['quantity' => 1]);

        $loan4 = Loan::withoutEvents(fn () => Loan::updateOrCreate(
            ['member_id' => $members[4]->id, 'loan_date' => now()->subDays(3)->toDateString()],
            ['due_date' => now()->addDays(4)->toDateString(), 'status' => LoanStatus::Borrowed, 'returned_at' => null]
        ));
        $loan4->details()->updateOrCreate(['book_id' => $books[5]->id], ['quantity' => 1]);

        $loan5 = Loan::withoutEvents(fn () => Loan::updateOrCreate(
            ['member_id' => $members[6]->id, 'loan_date' => now()->subDays(15)->toDateString()],
            ['due_date' => now()->subDays(8)->toDateString(), 'status' => LoanStatus::Returned, 'returned_at' => now()->subDays(7)]
        ));
        $loan5->details()->updateOrCreate(['book_id' => $books[9]->id], ['quantity' => 2]);
    }
}