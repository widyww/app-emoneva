# 3. HASIL DAN PEMBAHASAN

## 3.1 Analisis

### 3.1.1. Software Development Life Cycle Waterfall dalam Pengembangan Sistem Informasi E-MONEVA Maluku
Metodologi *Software Development Life Cycle* (SDLC) *Waterfall* merupakan pendekatan sistematis dalam pengembangan perangkat lunak, di mana setiap tahapan dilakukan secara berurutan[8]. Berikut adalah tahapan-tahapan utama pada *Waterfall* dan penerapannya dalam pengembangan sistem informasi E-MONEVA (e-Monitoring dan e-Evaluasi Kesiapan TIK & Kompetensi Guru) di Balai Teknologi Informasi dan Komunikasi (BTKI) Dinas Pendidikan Provinsi Maluku.

<div align="center">

**Tabel 1. Tahapan Waterfall**

</div>

| No | Tahapan | Deskripsi | Contoh Implementasi |
| :---: | :--- | :--- | :--- |
| **1** | Requirement | Mengumpulkan dan menganalisis kebutuhan sistem secara menyeluruh dari pemangku kepentingan. | Identifikasi kebutuhan fungsional (seperti 22 Use Cases untuk 5 aktor) dan kebutuhan non-fungsional, serta wawancara dengan BTKI Dinas Pendidikan Provinsi Maluku mengenai alur monitoring TIK sekolah dan kompetensi TIK guru. |
| **2** | Design | Merancang arsitektur sistem, termasuk desain antarmuka pengguna dan alur kerja sistem. | Perancangan ERD database (13 tabel utama seperti `users`, `sekolahs`, `gurus`, `sekolah_fasilitas`, dll.), diagram UML (Use Case, Sequence, Class), serta rancangan antarmuka responsif menggunakan SB Admin 2. |
| **3** | Implementation | Menerapkan desain menjadi kode program atau perangkat lunak yang fungsional. | Menulis kode backend menggunakan framework Laravel (routes di `web.php`, logic di level Controller seperti `GuruDashboardController` dan `FilterAkreditasiController`), migrasi database MySQL, serta pembuatan antarmuka Blade dengan integrasi CSS/JS kustom. |
| **4** | Verification | Menguji sistem untuk memastikan fungsionalitas berjalan sesuai kebutuhan. | Pengujian fungsional menggunakan Black-Box Testing pada formulir isian sarana TIK sekolah dan profil kompetensi guru, unit testing dengan PHPUnit, serta User Acceptance Testing (UAT) menggunakan skala System Usability Scale (SUS). |
| **5** | Maintenance | Menyediakan dukungan dan pembaruan sistem pasca implementasi untuk mengatasi permasalahan atau penyesuaian terhadap regulasi baru. | Penanganan perbaikan bug (*bug fixing*) yang dilaporkan pengguna pasca deployment pada web server BTKI Dinas Pendidikan Maluku, optimalisasi query basis data, serta pembaruan data periode monitoring tahun ajaran baru. |

---

### 3.1.2. Software Development Life Cycle Agile dalam Pengembangan Sistem Informasi E-MONEVA Maluku
Metodologi *Agile* dalam pengembangan sistem informasi terdiri dari beberapa tahapan utama yang bersifat iteratif dan fleksibel, memungkinkan sistem berkembang secara bertahap sesuai dengan kebutuhan pengguna dan perubahan instrumen evaluasi[9]. Pendekatan ini sangat cocok untuk sistem E-MONEVA yang sering membutuhkan penyesuaian cepat terhadap perubahan parameter kesiapan TIK dan kebutuhan analisis data di lapangan[10]. Berikut adalah tahapan utama *Agile* yang diterapkan pada pengembangan sistem informasi E-MONEVA di Dinas Pendidikan Provinsi Maluku.

<div align="center">

**Tabel 2. Tahapan Agile**

</div>

| No | Tahapan | Deskripsi | Contoh Implementasi |
| :---: | :--- | :--- | :--- |
| **1** | Iterasi | Pengembangan dilakukan dalam siklus pendek (*sprint*) dengan tujuan menghasilkan versi awal sistem yang dapat dievaluasi. | Siklus pengembangan awal yang difokuskan pada modul fungsional inti, seperti modul Autentikasi User (5 role) dan formulir pengisian data dasar profil Guru Mandiri. |
| **2** | Increment | Setiap iterasi menghasilkan fitur baru atau perbaikan yang menambah nilai pada sistem secara bertahap. | Penambahan fitur visualisasi chart statistik (Chart.js) untuk Kabalai dan integrasi pop-up notifikasi SweetAlert2 setelah modul pengajuan verifikasi selesai diimplementasikan. |
| **3** | Kolaborasi | Mengutamakan komunikasi intensif antara tim pengembang, pengguna akhir, dan pemangku kepentingan. | Diskusi mingguan dengan perwakilan Operator Sekolah dan Verifikator BTKI untuk menyesuaikan validasi kolom isian fasilitas TIK (misalnya data ketersediaan listrik dan bandwidth internet) agar sesuai kondisi nyata di Maluku. |

---

### 3.1.3. Perbandingan Metodologi Waterfall dan Agile
Dalam pengembangan sistem informasi E-MONEVA, perbandingan metodologi *Waterfall* dan *Agile* dapat dilihat dari berbagai aspek seperti waktu, biaya, kualitas hasil, kemampuan adaptasi terhadap perubahan kebijakan, dan relevansinya dengan karakteristik wilayah Kepulauan Maluku.
Berikut adalah analisis mendalam dari masing-masing aspek perbandingan metodologi *Waterfall* dan *Agile*:

#### a. Aspek Waktu, Biaya, dan Kualitas Hasil Pengembangan

<div align="center">

**Tabel 3. Perbandingan Metodologi**

</div>

| No | Aspek | Waterfall | Agile |
| :---: | :--- | :--- | :--- |
| **1** | Waktu | Waktu pengembangan cenderung lebih lama karena setiap tahapan harus selesai sebelum melanjutkan. | Iterasi pendek memungkinkan pengiriman fitur awal lebih cepat, tetapi durasi total dapat bervariasi jika banyak iterasi diperlukan. |
| **2** | Biaya | Biaya dapat diprediksi dengan lebih baik karena seluruh rencana dikunci sejak awal. | Biaya cenderung dinamis, bergantung pada jumlah iterasi dan perubahan kebutuhan selama proses pengembangan. |
| **3** | Kualitas | Kualitas bergantung pada akurasi analisis awal. Kesalahan yang ditemukan di tahap akhir dapat memengaruhi hasil secara signifikan. | Kualitas cenderung lebih tinggi karena iterasi memungkinkan pengujian dan peningkatan berkelanjutan. |

##### Kesimpulan:
1. *Waterfall* cocok untuk proyek dengan kebutuhan yang tetap dan anggaran terbatas, tetapi kurang fleksibel jika terjadi perubahan kebutuhan di tengah jalan.
2. *Agile* lebih unggul untuk proyek dengan kebutuhan dinamis karena memungkinkan peningkatan kualitas melalui iterasi.

#### b. Kemampuan Adaptasi terhadap Perubahan Regulasi/Kebijakan Monitoring TIK

<div align="center">

**Tabel 4. Kemampuan Adaptasi Metodologi**

</div>

| No | Kriteria | Waterfall | Agile |
| :---: | :--- | :--- | :--- |
| **1** | Responsivitas | Sulit beradaptasi karena perubahan kriteria penilaian/instrumen Monev memerlukan revisi dari tahap analisis awal. | Sangat responsif, setiap iterasi dapat menyesuaikan instrumen isian atau filter data baru tanpa harus merombak seluruh sistem dari awal. |
| **2** | Pengelolaan Risiko | Risiko kegagalan sistem terdeteksi terlambat jika ketidaksesuaian baru ditemukan pada tahap pengujian akhir. | Risiko lebih kecil karena setiap *sprint* mengevaluasi fungsionalitas terkini dan langsung mengatasi bug atau kesalahan logika yang muncul. |

*Agile lebih unggul dalam mengakomodasi pembaruan regulasi/kebijakan monitoring yang sering terjadi, seperti pembaruan aturan dari kementerian pendidikan, dinas pendidikan, atau lembaga terkait lainnya.*

#### c. Relevansi terhadap Karakteristik Sistem Informasi E-MONEVA (Wilayah Maluku)

<div align="center">

**Tabel 5. Relevansi Metodologi**

</div>

| No | Aspek | Waterfall | Agile |
| :---: | :--- | :--- | :--- |
| **1** | Kesesuaian | Struktur terencana dan dokumentasi lengkap membantu memenuhi kebutuhan standar pelaporan birokrasi kedinasan secara formal. | Kolaborasi intensif mempermudah penyesuaian terhadap variasi kondisi infrastruktur TIK di berbagai sekolah di Maluku yang dinamis. |
| **2** | Efisiensi Implementasi | Proses panjang dapat memengaruhi ketepatan waktu penerapan sistem dalam satu periode monitoring yang mendesak. | Iterasi pendek mendukung pengembangan yang cepat dan sesuai dengan urgensi kebutuhan pengambilan kebijakan BTKI. |

*Waterfall menawarkan kejelasan dalam dokumentasi, yang penting untuk menjamin kesesuaian dengan standar pelaporan formal Dinas Pendidikan. Agile lebih relevan jika sistem E-MONEVA membutuhkan inovasi berkelanjutan, seperti pengelolaan risiko dan penyesuaian data monitoring TIK secara berkala[11].*

#### d. Ringkasan Perbandingan

<div align="center">

**Tabel 6. Ringkasan Perbandingan**

</div>

| No | Aspek | Waterfall | Agile |
| :---: | :--- | :--- | :--- |
| **1** | Waktu | Lebih lama, tidak fleksibel. | Lebih cepat dalam iterasi awal, tetapi durasi total dapat bervariasi jika banyak iterasi diperlukan. |
| **2** | Biaya | Cenderung tetap, tetapi sulit mengakomodasi perubahan. | Dinamis, bergantung pada jumlah iterasi dan perubahan kebutuhan selama proses. |
| **3** | Kualitas | Bergantung pada akurasi analisis awal. Kesalahan di tahap akhir dapat memengaruhi hasil secara signifikan. | Kualitas lebih baik melalui evaluasi dan pengujian iteratif. |
| **4** | Adaptasi Regulasi | Sulit mengakomodasi perubahan regulasi/kebijakan monitoring yang dinamis. | Fleksibel, perubahan dapat langsung diterapkan di iterasi berikutnya. |
| **5** | Relevansi E-MONEVA | Cocok untuk sistem yang sangat terstruktur dan sesuai regulasi formal sejak awal. | Lebih relevan untuk kebutuhan yang dinamis, memungkinkan penyesuaian dengan prinsip monitoring yang terus berkembang. |

Dalam pengembangan sistem informasi E-MONEVA di Dinas Pendidikan Provinsi Maluku:
1. *Waterfall* cocok untuk kebutuhan yang stabil, proyek yang membutuhkan dokumentasi lengkap, dan anggaran yang tetap.
2. *Agile* lebih relevan untuk lingkungan yang dinamis, seperti kebutuhan visualisasi data baru oleh Kabalai yang memerlukan penyesuaian terus-menerus terhadap regulasi dan inovasi teknologi.

*Pemilihan metodologi sebaiknya disesuaikan dengan kebutuhan proyek, tingkat fleksibilitas yang diinginkan, dan ketersediaan sumber daya.*

---

## 3.2 Hasil Implementasi dan Perbandingan

Hasil penelitian yang diperoleh melalui wawancara mendalam dan observasi terhadap tim pengembang dan perwakilan Dinas Pendidikan Provinsi Maluku. Hasil ini mencakup analisis efektivitas penerapan metodologi *Software Development Life Cycle* (SDLC) *Waterfall* dan *Agile* dalam pengembangan sistem informasi E-MONEVA[12]. Penelitian ini bertujuan untuk memahami sejauh mana kedua metodologi tersebut dapat memenuhi kebutuhan sistem yang fleksibel, efisien, dan mampu beradaptasi terhadap perubahan parameter monitoring yang dinamis.

### 3.2.1. Implementasi Prototipe dengan Metodologi Waterfall
* **a. Tahapan:** Prototipe dikembangkan secara bertahap mulai dari *requirement gathering*, *design*, *implementation*, *testing*, hingga *deployment*. Tidak ada iterasi selama proses berlangsung, dan setiap tahap diselesaikan sepenuhnya sebelum melanjutkan ke tahap berikutnya.
* **b. Pengujian:** Dilakukan setelah seluruh sistem selesai dikembangkan, menggunakan data simulasi kesiapan TIK sekolah dan kompetensi guru dari Dinas Pendidikan Provinsi Maluku. Fokus pengujian adalah validasi fitur pelaporan dan akurasi grafik statistik.
* **c. Hasil:**
  1. Pengembangan memakan waktu lebih lama karena sifatnya yang linier.
  2. Sistem cenderung stabil, tetapi kurang fleksibel saat ditemukan kebutuhan tambahan, seperti integrasi modul filter kuota internet baru.
  3. Biaya pengembangan meningkat ketika ada revisi pada tahap akhir karena memerlukan modifikasi desain awal.

### 3.2.2. Implementasi Prototipe dengan Metodologi Agile
* **a. Tahapan:** Pengembangan dilakukan dalam beberapa iterasi (*sprint*), masing-masing berdurasi dua minggu. Setiap iterasi menghasilkan versi prototipe dengan fitur tertentu, seperti fitur pengolahan data kesiapan TIK sekolah, portofolio kompetensi guru, dan dashboard statistik Kabalai.
* **b. Pengujian:** Dilakukan secara berkala setelah setiap iterasi, dengan melibatkan pengguna akhir (Operator Sekolah dan Guru) untuk memberikan umpan balik langsung. Fokus pengujian adalah kegunaan (*usability*) dan kemampuan adaptasi sistem terhadap perubahan instrumen monitoring yang muncul selama proses pengembangan.
* **c. Hasil:**
  1. Pengembangan lebih cepat karena fokus pada fitur prioritas pada tiap sprint.
  2. Sistem lebih fleksibel dalam mengakomodasi perubahan instrumen atau kriteria monitoring baru.
  3. Pengujian dan revisi terus-menerus menghasilkan sistem yang lebih sesuai dengan kebutuhan operasional pengguna di lapangan.

### 3.2.3. Implementasi Prototipe dengan Metodologi Hybrid
Sebagai contoh praktis, pengembangan sistem pelaporan kesiapan TIK terpadu dapat menggunakan kombinasi kedua metodologi (Hybrid Model). Tahapan awal perencanaan dan analisis kebutuhan dilaksanakan menggunakan pendekatan *Waterfall* untuk memastikan kelengkapan dokumentasi instrumen monitoring dan kebutuhan birokrasi Dinas Pendidikan. Sementara itu, pengembangan modul-modul sistem (seperti dashboard Kabalai, form isian sarpras Operator Sekolah, dan penginputan kompetensi Guru) dilakukan secara iteratif dengan pendekatan *Agile* agar lebih fleksibel dalam menyesuaikan perubahan kebijakan dan kendala lapangan. Pendekatan ini selaras dengan prinsip efisiensi, akurasi data, keamanan, dan skalabilitas sistem E-MONEVA.

### 3.2.4. Kesimpulan Hasil Pengujian
Hasil implementasi prototipe sistem informasi E-MONEVA menunjukkan bahwa metodologi *Agile* memiliki kinerja lebih baik dalam aspek waktu, efisiensi, dan fleksibilitas. *Agile* mampu menghadirkan solusi yang lebih cepat dan adaptif terhadap kebutuhan Dinas Pendidikan Provinsi Maluku, terutama dalam menghadapi perubahan kebijakan monitoring kesiapan TIK[13].

Sebaliknya, *Waterfall* memberikan keunggulan dalam stabilitas hasil, tetapi menghadapi keterbatasan dalam menyesuaikan sistem dengan kebutuhan baru, sehingga kurang optimal untuk lingkungan pengembangan perangkat lunak yang dinamis dengan batas waktu skripsi yang ketat.

---

## 3.3 Pembahasan

### 3.3.1. Analisis Mendalam dari Temuan Utama
Hasil penelitian menunjukkan perbedaan signifikan antara metodologi *Software Development Life Cycle* (SDLC) *Waterfall* dan *Agile* dalam pengembangan sistem informasi E-MONEVA di Dinas Pendidikan Provinsi Maluku sebagai berikut:
* **a. Efisiensi Waktu dan Biaya:**
  * 1. *Waterfall:* Meskipun memberikan hasil yang stabil, metodologi ini membutuhkan waktu lebih lama dan biaya tambahan ketika terjadi revisi di tahap akhir. Hal ini disebabkan oleh sifatnya yang linier, sehingga setiap perubahan memerlukan pengulangan proses dari awal.
  * 2. *Agile:* Metodologi ini lebih efisien dalam waktu dan biaya, karena iterasi memungkinkan pengembangan dilakukan secara bertahap, dengan fitur prioritas yang langsung diuji dan diperbaiki. *Agile* memanfaatkan sumber daya secara optimal dengan mengurangi kebutuhan revisi besar.
* **b. Kemampuan Beradaptasi dengan Regulasi yang Dinamis:**
  * 1. *Waterfall:* Kurang fleksibel dalam menghadapi perubahan regulasi/kebijakan monitoring kesiapan TIK yang sering terjadi di tingkat daerah maupun kementerian. Sistem cenderung kaku karena seluruh tahapan harus selesai sebelum perubahan dapat diterapkan.
  * 2. *Agile:* Sangat fleksibel dalam menyesuaikan kebutuhan sistem dengan regulasi baru. Iterasi memberikan ruang bagi tim untuk menambahkan fitur atau memperbaiki sistem di tengah proses pengembangan tanpa mengganggu keseluruhan proyek.
* **c. Kesesuaian dengan Kebutuhan Dinas Pendidikan Maluku:**
  * 1. *Waterfall:* Mampu memenuhi kebutuhan sistem yang kompleks tetapi kurang responsif terhadap pembaruan regulasi dinamis yang membutuhkan pengembangan berkelanjutan.
  * 2. *Agile:* Lebih sesuai untuk kebutuhan Dinas Pendidikan Maluku karena sifatnya yang iteratif dan kolaboratif. *Agile* mendukung pengembangan sistem yang adaptif terhadap dinamika regulasi dan kebutuhan pengguna.

### 3.3.2. Rekomendasi Penggunaan Metodologi untuk Pengembangan Sistem di Masa Depan
Berdasarkan analisis temuan penelitian, *Agile* direkomendasikan untuk pengembangan sistem di masa depan karena fleksibilitasnya dalam menghadapi perubahan regulasi dan kebutuhan instansi. Pendekatan iteratifnya memungkinkan evaluasi berkelanjutan sehingga sistem lebih adaptif dan efisien. Berikut adalah rekomendasi penggunaan metodologi untuk pengembangan sistem di masa depan di Dinas Pendidikan Provinsi Maluku:
* **a. Prioritaskan Metodologi Agile untuk Sistem yang Dinamis:**
  * *Agile* direkomendasikan untuk proyek yang membutuhkan fleksibilitas tinggi, seperti pengembangan visualisasi statistik terintegrasi (Chart.js) dan modul pemetaan wilayah baru. *Agile* memungkinkan adaptabilitas berkelanjutan untuk merespons perubahan kebutuhan analisis secara cepat dan efisien.
* **b. Gunakan Waterfall untuk Proyek Stabil dan Berstruktur:**
  * Metodologi *Waterfall* dapat digunakan untuk proyek dengan kebutuhan yang stabil dan jarang berubah, seperti sistem otentikasi dasar dan modul pengelolaan data master wilayah. *Waterfall* dapat memberikan hasil yang solid ketika kebutuhan awal sudah sangat jelas dan tidak memerlukan banyak revisi.
* **c. Pertimbangkan Hybrid Model:**
  * Kombinasi *Waterfall* dan *Agile* (*Hybrid Model*) dapat menjadi alternatif untuk proyek berskala besar di mana beberapa bagian membutuhkan stabilitas (menggunakan *Waterfall*) sementara bagian lainnya memerlukan fleksibilitas tinggi (menggunakan *Agile*). Misalnya, *Waterfall* dapat digunakan untuk pengembangan arsitektur sistem, sementara *Agile* digunakan untuk fitur yang dinamis seperti pelaporan dan notifikasi.
* **d. Investasi dalam Pelatihan Agile:**
  * Agar implementasi *Agile* lebih efektif, tim pengembang dan perwakilan dinas perlu berinvestasi dalam pelatihan tim pengembang, manajemen, dan pemangku kepentingan lainnya. Pemahaman yang baik tentang prinsip *Agile* akan meningkatkan kolaborasi dan efisiensi dalam pengembangan sistem.
* **e. Evaluasi Kebutuhan Secara Berkala:**
  * Sebelum memilih metodologi, instansi harus mengevaluasi kebutuhan proyek secara berkala. Faktor seperti urgensi regulasi, kompleksitas sistem, dan keterbatasan sumber daya harus dipertimbangkan untuk memastikan metodologi yang dipilih dapat memenuhi kebutuhan secara optimal.

### 3.3.3. Hambatan dalam Proses Pengembangan
Selama proses pengembangan sistem informasi E-MONEVA di lingkungan Dinas Pendidikan Provinsi Maluku, terdapat beberapa hambatan yang dihadapi tim pengembang. Salah satu hambatan utama adalah perubahan instrumen atau parameter penilaian TIK yang mendadak. Di sektor pendidikan, indikator kesiapan TIK sering kali mengalami pembaruan yang cepat dan membutuhkan penyesuaian yang segera. Hal ini membuat pengembang harus siap mengubah backlog dan prioritas proyek secara cepat, sehingga tim harus bekerja lebih cepat dan efisien untuk memastikan bahwa sistem yang dikembangkan tetap relevan dan mematuhi instrumen penilaian terbaru. Meskipun metodologi *Agile* memberikan fleksibilitas untuk menangani perubahan ini, proses penyesuaian yang terus-menerus tetap memerlukan waktu dan upaya tambahan, yang dapat mempengaruhi alur kerja dan jadwal pengembangan[14].

Selain itu, kurangnya pemahaman terhadap kebutuhan pengguna juga sering menjadi hambatan. Dalam beberapa kasus, tim pengembang mungkin belum sepenuhnya memahami kebutuhan spesifik dari pengguna akhir, terutama dalam hal fungsionalitas yang diperlukan untuk memastikan keakuratan pelaporan kesiapan TIK sekolah[5]. Komunikasi yang tidak optimal antara tim pengembang dan pemangku kepentingan dapat menyebabkan kesalahan dalam perencanaan dan pengembangan sistem, yang pada akhirnya dapat mempengaruhi kualitas dan keberhasilan sistem yang dihasilkan. Dalam beberapa situasi, tim pengembang juga menghadapi kendala teknis, seperti keterbatasan infrastruktur teknologi (keterbatasan bandwidth di daerah 3T) atau kesulitan dalam integrasi sistem baru dengan database sekolah yang lama, yang memerlukan lebih banyak waktu untuk diatasi.

#### a. Keberhasilan Sistem
Keberhasilan sistem informasi dalam memenuhi kebutuhan monitoring kesiapan TIK sangat bergantung pada kemampuan sistem untuk beradaptasi dengan indikator evaluasi yang terus berubah. Seperti yang dibahas dalam analisis sebelumnya, metodologi *Agile* memungkinkan tim untuk melakukan iterasi dan penyesuaian cepat terhadap sistem yang sedang dikembangkan. Dalam konteks monitoring kesiapan TIK sekolah dan kompetensi guru, hal ini memungkinkan sistem untuk selalu memperbarui fungsionalitasnya sesuai dengan perubahan kriteria penilaian yang dikeluarkan oleh otoritas Dinas Pendidikan. Sistem yang dibangun dengan pendekatan ini cenderung lebih responsif terhadap persyaratan pengumpulan data baru, yang merupakan faktor penting dalam menghindari potensi kesalahan pengambilan keputusan dan memastikan bahwa Dinas Pendidikan Provinsi Maluku dapat merumuskan program bantuan TIK sesuai dengan standar yang ditetapkan[15][16].

Selain itu, feedback positif dari pengguna juga merupakan indikator keberhasilan sistem dalam memenuhi kebutuhan monitoring[17]. Dengan adanya komunikasi yang terbuka dan mekanisme feedback yang rutin, seperti yang diterapkan dalam metodologi *Agile*, tim pengembang dapat terus memperbaiki sistem berdasarkan kebutuhan dan harapan pengguna (Operator Sekolah dan Guru). Hal ini memastikan bahwa sistem yang dikembangkan tidak hanya memenuhi standar teknis, tetapi juga relevan dengan kebutuhan praktis dan operasional pengguna. Keberhasilan sistem dalam memenuhi tujuan monitoring juga tercermin dari kemampuannya untuk mengurangi risiko kesalahan dalam proses pelaporan data, mengotomatisasi prosedur verifikasi berkas pendukung, serta meningkatkan transparansi dalam penyusunan grafik statistik bagi kepala balai[2][18]. Dengan demikian, sistem yang efektif tidak hanya membantu memastikan akurasi data monitoring, tetapi juga meningkatkan efisiensi operasional dan mengurangi risiko yang terkait dengan pengelolaan penyaluran bantuan TIK sekolah di Provinsi Maluku[19].

#### b. Implikasi Hasil Penelitian
1. **Manajemen Proyek yang Lebih Adaptif**
   Dinas Pendidikan Provinsi Maluku dapat menerapkan manajemen proyek yang lebih adaptif dengan menggunakan *Agile*, terutama untuk proyek pengembangan sistem informasi pelayanan publik yang membutuhkan pembaruan berkala.
2. **Peningkatan Efisiensi Operasional**
   Metodologi *Agile* meningkatkan efisiensi operasional dalam pengembangan sistem E-MONEVA dengan memungkinkan iterasi yang lebih cepat dan adaptasi yang lebih fleksibel terhadap perubahan instrumen evaluasi. Dengan menerapkan *Agile*, pengembang dapat mengurangi waktu pengembangan, biaya revisi, dan mempercepat waktu peluncuran sistem ke pengguna akhir[20].
3. **Peningkatan Kualitas Kebijakan Digitalisasi Sekolah**
   Fleksibilitas *Agile* dalam mengakomodasi perubahan instrumen monitoring secara dinamis dapat meningkatkan keakuratan data kesiapan TIK sekolah sekaligus memberikan dasar pengambilan kebijakan yang lebih objektif bagi BTKI Dinas Pendidikan.
4. **Penguatan Sistem Informasi Pendidikan yang Berkelanjutan**
   Metodologi yang dipilih harus mendukung pengembangan sistem informasi yang sesuai dengan kebutuhan peningkatan kompetensi TIK guru dan mampu menjawab tantangan kesenjangan infrastruktur digital di daerah kepulauan Maluku.

*Dengan rekomendasi dan implikasi ini, Dinas Pendidikan Provinsi Maluku dapat mengoptimalkan pengembangan sistem informasi E-MONEVA, meningkatkan efektivitas operasional, dan memperkuat kualitas pengelolaan data sarana TIK pendidikan.*
