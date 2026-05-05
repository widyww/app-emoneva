import json
import os
import re
import sys
from collections import Counter


os.environ.setdefault("JOBLIB_MULTIPROCESSING", "0")
os.environ.setdefault("OMP_NUM_THREADS", "1")
os.environ.setdefault("OPENBLAS_NUM_THREADS", "1")
os.environ.setdefault("MKL_NUM_THREADS", "1")
os.environ.setdefault("NUMEXPR_NUM_THREADS", "1")


CATEGORIES = {
    "Microsoft Office dan Administrasi": [
        "office",
        "word",
        "excel",
        "powerpoint",
        "power point",
        "spreadsheet",
        "administrasi",
        "surat",
        "dokumen",
        "olah data",
    ],
    "Pembelajaran Digital dan LMS": [
        "digital",
        "online",
        "daring",
        "lms",
        "moodle",
        "google classroom",
        "classroom",
        "elearning",
        "e-learning",
        "media belajar",
        "canva pembelajaran",
    ],
    "AI dan Teknologi Pembelajaran": [
        "ai",
        "artificial intelligence",
        "kecerdasan buatan",
        "chatgpt",
        "gpt",
        "prompt",
        "machine learning",
        "teknologi pembelajaran",
    ],
    "Pemrograman dan Coding": [
        "program",
        "pemrograman",
        "coding",
        "kode",
        "python",
        "web",
        "html",
        "css",
        "javascript",
        "laravel",
        "php",
        "database",
        "basis data",
    ],
    "Jaringan dan Infrastruktur TIK": [
        "jaringan",
        "network",
        "internet",
        "wifi",
        "router",
        "mikrotik",
        "server",
        "komputer",
        "hardware",
        "troubleshooting",
    ],
    "Multimedia dan Desain Konten": [
        "multimedia",
        "desain",
        "design",
        "grafis",
        "video",
        "editing",
        "edit video",
        "animasi",
        "foto",
        "konten",
        "canva",
    ],
    "Kurikulum dan Perangkat Ajar": [
        "kurikulum",
        "merdeka",
        "rpp",
        "modul ajar",
        "perangkat ajar",
        "cp",
        "tp",
        "atp",
        "silabus",
        "pembelajaran berdiferensiasi",
    ],
    "Asesmen dan Evaluasi Pembelajaran": [
        "asesmen",
        "assessment",
        "evaluasi",
        "penilaian",
        "rubrik",
        "soal",
        "ujian",
        "akm",
        "rapor",
    ],
    "Penelitian Tindakan Kelas dan Publikasi": [
        "ptk",
        "penelitian",
        "karya tulis",
        "publikasi",
        "artikel",
        "jurnal",
        "ilmiah",
    ],
    "Manajemen Kelas dan Inklusi": [
        "kelas",
        "manajemen kelas",
        "karakter",
        "disiplin",
        "inklusi",
        "inklusif",
        "bk",
        "konseling",
        "anak berkebutuhan khusus",
    ],
    "Penguatan Pedagogik dan Mapel": [
        "pedagogik",
        "pedagogi",
        "metode",
        "strategi",
        "model pembelajaran",
        "matematika",
        "bahasa",
        "ipa",
        "ips",
        "agama",
        "pjok",
        "seni",
        "produktif",
    ],
}

RECOMMENDATIONS = {
    "Microsoft Office dan Administrasi": "Pelatihan praktik Word, Excel, PowerPoint, dan pengelolaan dokumen sekolah.",
    "Pembelajaran Digital dan LMS": "Pelatihan pembuatan kelas digital, LMS, dan media pembelajaran interaktif.",
    "AI dan Teknologi Pembelajaran": "Pelatihan pemanfaatan AI untuk perencanaan, materi ajar, asesmen, dan produktivitas guru.",
    "Pemrograman dan Coding": "Pelatihan dasar pemrograman, web, database, dan proyek coding sederhana.",
    "Jaringan dan Infrastruktur TIK": "Pelatihan jaringan dasar, internet sekolah, perangkat komputer, dan troubleshooting.",
    "Multimedia dan Desain Konten": "Pelatihan desain grafis, video pembelajaran, animasi, dan produksi konten ajar.",
    "Kurikulum dan Perangkat Ajar": "Pelatihan Kurikulum Merdeka, modul ajar, ATP, dan pembelajaran berdiferensiasi.",
    "Asesmen dan Evaluasi Pembelajaran": "Pelatihan asesmen formatif-sumatif, rubrik, soal, dan analisis hasil belajar.",
    "Penelitian Tindakan Kelas dan Publikasi": "Pelatihan PTK, penulisan artikel ilmiah, dan publikasi karya guru.",
    "Manajemen Kelas dan Inklusi": "Pelatihan manajemen kelas, pendidikan karakter, layanan inklusi, dan pendampingan siswa.",
    "Penguatan Pedagogik dan Mapel": "Pelatihan strategi mengajar, model pembelajaran, dan pendalaman materi sesuai mapel.",
    "Lainnya": "Perlu telaah manual untuk menentukan kelas pelatihan yang paling sesuai.",
}


def clean(text):
    text = (text or "").lower()
    text = re.sub(r"[^a-z0-9+#.\s-]", " ", text)
    text = re.sub(r"\s+", " ", text).strip()
    return text


def keyword_label(text):
    normalized = clean(text)
    best_label = "Lainnya"
    best_score = 0

    for label, keywords in CATEGORIES.items():
        score = 0
        for keyword in keywords:
            pattern = clean(keyword)
            if pattern and pattern in normalized:
                score += 2 if " " in pattern else 1

        if score > best_score:
            best_label = label
            best_score = score

    confidence = min(0.95, 0.45 + (best_score * 0.12)) if best_score else 0.35

    return best_label, confidence


def seed_training_data():
    texts = []
    labels = []

    for label, keywords in CATEGORIES.items():
        for keyword in keywords:
            texts.extend(
                [
                    keyword,
                    f"pelatihan {keyword}",
                    f"butuh peningkatan {keyword}",
                    f"belajar {keyword}",
                    f"penguatan kompetensi {keyword}",
                ]
            )
            labels.extend([label] * 5)

    return texts, labels


def classify_with_random_forest(records):
    from sklearn.ensemble import RandomForestClassifier
    from sklearn.feature_extraction.text import TfidfVectorizer
    from sklearn.pipeline import Pipeline

    training_texts, training_labels = seed_training_data()

    for record in records:
        text = record["kebutuhan"]
        label, confidence = keyword_label(text)

        if label != "Lainnya" and confidence >= 0.57:
            training_texts.append(text)
            training_labels.append(label)

    model = Pipeline(
        [
            ("vectorizer", TfidfVectorizer(analyzer="char_wb", ngram_range=(3, 5), min_df=1)),
            (
                "classifier",
                RandomForestClassifier(
                    n_estimators=180,
                    random_state=42,
                    class_weight="balanced_subsample",
                    n_jobs=1,
                ),
            ),
        ]
    )
    model.fit(training_texts, training_labels)

    texts = [record["kebutuhan"] for record in records]
    predictions = model.predict(texts) if texts else []
    probabilities = model.predict_proba(texts) if texts else []
    classes = list(model.named_steps["classifier"].classes_)

    results = []

    for record, label, row_probabilities in zip(records, predictions, probabilities):
        confidence = float(row_probabilities[classes.index(label)])
        keyword_prediction, keyword_confidence = keyword_label(record["kebutuhan"])

        if keyword_prediction != "Lainnya" and keyword_confidence > confidence:
            label = keyword_prediction
            confidence = keyword_confidence

        results.append({**record, "category": label, "confidence": round(confidence, 3)})

    vectorizer = model.named_steps["vectorizer"]
    classifier = model.named_steps["classifier"]
    feature_names = vectorizer.get_feature_names_out()
    importances = classifier.feature_importances_
    important_terms = [
        {"label": feature_names[index].strip(), "value": round(float(importances[index]), 5)}
        for index in sorted(range(len(importances)), key=lambda item: importances[item], reverse=True)[:12]
        if feature_names[index].strip()
    ]

    return results, important_terms


def classify_with_keywords(records):
    results = []

    for record in records:
        label, confidence = keyword_label(record["kebutuhan"])
        results.append({**record, "category": label, "confidence": round(confidence, 3)})

    return results, []


def build_output(records):
    if not records:
        return {
            "engine": "empty",
            "message": "Belum ada data kebutuhan pelatihan guru untuk dianalisis.",
            "accuracy": None,
            "summary": {
                "total": 0,
                "total_guru": 0,
                "total_categories": 0,
                "dominant_category": "-",
                "uncategorized": 0,
            },
            "feature_importance": [],
            "top_needs": [],
            "rows": [],
        }

    try:
        rows, important_terms = classify_with_random_forest(records)
        engine = "random_forest"
        message = "Klasifikasi memakai Random Forest dari teks kebutuhan pelatihan guru."
    except Exception:
        rows, important_terms = classify_with_keywords(records)
        engine = "keyword"
        message = "Klasifikasi berbasis kata kunci aktif. Untuk Random Forest penuh, pastikan scikit-learn terpasang dan Python berjalan normal."

    category_counts = Counter(row["category"] for row in rows)
    dominant = category_counts.most_common(1)[0][0] if category_counts else "-"

    rows = [
        {
            **row,
            "recommendation": RECOMMENDATIONS.get(row["category"], RECOMMENDATIONS["Lainnya"]),
        }
        for row in rows
    ]
    rows.sort(key=lambda row: (row["category"] == "Lainnya", -row["confidence"], row["category"]))

    return {
        "engine": engine,
        "message": message,
        "accuracy": None,
        "summary": {
            "total": len(rows),
            "total_guru": len({row.get("guru_id") for row in rows if row.get("guru_id")}),
            "total_categories": len(category_counts),
            "dominant_category": dominant,
            "uncategorized": category_counts["Lainnya"],
        },
        "feature_importance": important_terms,
        "top_needs": [
            {"name": name, "count": count}
            for name, count in category_counts.most_common()
        ],
        "rows": rows[:500],
    }


def main():
    payload = json.load(sys.stdin)
    records = []

    for item in payload.get("records") or []:
        text = (item.get("kebutuhan") or "").strip()

        if not text:
            continue

        records.append(
            {
                "id": item.get("id"),
                "guru_id": item.get("guru_id"),
                "nama": item.get("nama") or "-",
                "sekolah": item.get("sekolah") or "-",
                "kota": item.get("kota") or "-",
                "mapel": item.get("mapel") or "-",
                "kebutuhan": text,
            }
        )

    print(json.dumps(build_output(records), ensure_ascii=False))


if __name__ == "__main__":
    main()
