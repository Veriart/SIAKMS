<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>API Docs — SIAK LMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--bg:#fafbfc;--card:#fff;--border:#e5e7eb;--text:#1f2937;--dim:#6b7280;--accent:#2563eb;--accent-light:#eff6ff;--green:#059669;--green-bg:#ecfdf5;--blue-bg:#eff6ff;--code-bg:#f8fafc;--dark-code:#1e293b}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);line-height:1.7}
code,pre{font-family:'JetBrains Mono',monospace}
a{color:var(--accent);text-decoration:none}

.wrap{max-width:860px;margin:0 auto;padding:40px 24px 80px}
header{text-align:center;margin-bottom:48px}
header h1{font-size:2rem;font-weight:800;margin-bottom:4px}
header p{color:var(--dim);font-size:.95rem}
header .ver{display:inline-block;margin-top:10px;font-size:.75rem;padding:4px 12px;border-radius:99px;background:var(--accent-light);color:var(--accent);font-weight:600}

/* Nav */
nav{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:40px;padding-bottom:20px;border-bottom:1px solid var(--border)}
nav a{padding:6px 14px;border-radius:8px;font-size:.82rem;font-weight:500;color:var(--dim);background:var(--card);border:1px solid var(--border);transition:.15s}
nav a:hover{color:var(--accent);border-color:var(--accent);background:var(--accent-light)}

/* Guide */
.guide{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:28px;margin-bottom:36px}
.guide h2{font-size:1.1rem;font-weight:700;margin-bottom:12px}
.guide .steps{counter-reset:s}
.guide .step{counter-increment:s;padding-left:32px;position:relative;margin-bottom:14px}
.guide .step::before{content:counter(s);position:absolute;left:0;top:1px;width:22px;height:22px;border-radius:50%;background:var(--accent);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center}
.guide .step p{font-size:.9rem;color:var(--dim)}
.guide .step code{background:var(--code-bg);padding:2px 7px;border-radius:5px;font-size:.82rem;color:var(--text);border:1px solid var(--border)}

/* Section */
.section{margin-bottom:40px}
.section-title{font-size:1.15rem;font-weight:700;margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid var(--accent)}

/* Endpoint */
.ep{background:var(--card);border:1px solid var(--border);border-radius:12px;margin-bottom:12px;overflow:hidden;transition:.15s}
.ep:hover{border-color:#cbd5e1;box-shadow:0 2px 8px rgba(0,0,0,.04)}
.ep-head{display:flex;align-items:center;gap:10px;padding:14px 18px;cursor:pointer;user-select:none}
.ep-head .m{padding:3px 10px;border-radius:6px;font-size:.7rem;font-weight:700;letter-spacing:.5px;font-family:'JetBrains Mono',monospace}
.m-get{background:var(--green-bg);color:var(--green)}
.m-post{background:var(--blue-bg);color:var(--accent)}
.ep-head .url{font-family:'JetBrains Mono',monospace;font-size:.85rem;font-weight:500}
.ep-head .label{margin-left:auto;color:var(--dim);font-size:.8rem}
.ep-head .arrow{color:var(--dim);font-size:.65rem;transition:.2s;margin-left:8px}
.ep.open .arrow{transform:rotate(90deg)}
.ep-detail{display:none;padding:0 18px 18px;border-top:1px solid var(--border)}
.ep.open .ep-detail{display:block;padding-top:16px}

/* Code blocks */
.cb{background:var(--dark-code);border-radius:10px;padding:16px 18px;margin:8px 0;overflow-x:auto;position:relative}
.cb pre{font-size:.8rem;line-height:1.8;color:#e2e8f0;white-space:pre;margin:0}
.cb .tag{position:absolute;top:8px;right:10px;font-size:.6rem;text-transform:uppercase;letter-spacing:1px;color:#64748b;font-weight:600}
.cb-light{background:var(--code-bg);border:1px solid var(--border)}
.cb-light pre{color:var(--text)}

/* Param table */
.params{width:100%;border-collapse:collapse;font-size:.83rem;margin:10px 0}
.params th{text-align:left;font-size:.7rem;text-transform:uppercase;letter-spacing:.5px;color:var(--dim);padding:6px 0;border-bottom:1px solid var(--border)}
.params td{padding:6px 0;border-bottom:1px solid #f1f5f9}
.params code{background:var(--code-bg);padding:2px 6px;border-radius:4px;font-size:.78rem;border:1px solid var(--border)}
.req{color:#dc2626;font-size:.7rem;font-weight:600}
.opt{color:var(--dim);font-size:.7rem}

.filter-chips{display:flex;flex-wrap:wrap;gap:5px;margin:8px 0}
.chip{background:var(--code-bg);border:1px solid var(--border);padding:3px 10px;border-radius:6px;font-size:.76rem;font-family:'JetBrains Mono',monospace;color:var(--dim)}

.note{font-size:.82rem;color:var(--dim);margin-top:6px}
.sub{font-size:.78rem;font-weight:600;color:var(--dim);text-transform:uppercase;letter-spacing:.5px;margin:12px 0 4px}
</style>
</head>
<body>
<div class="wrap">

<header>
    <h1>SIAK LMS API</h1>
    <p>RESTful API Documentation — Sistem Informasi Akademik</p>
    <span class="ver">v1.0 · Laravel Sanctum</span>
</header>

<nav id="nav"></nav>

<!-- AUTH GUIDE -->
<div class="guide">
    <h2>&#128274; Cara Menggunakan API</h2>
    <div class="steps">
        <div class="step">
            <p><strong>Login</strong> — kirim email & password ke <code>POST /api/login</code></p>
            <div class="cb"><span class="tag">Request</span><pre>POST /api/login
Content-Type: application/json

{
  "email": "admin@smkmetland.net",
  "password": "password123"
}</pre></div>
            <div class="cb"><span class="tag">Response</span><pre>{
  "message": "Login berhasil",
  "user": {
    "id": 1,
    "name": "Admin",
    "roles": [{ "name": "Admin" }]
  },
  "token": "3|aB4cD5eF6gH7iJ8kL9mN0oP1qR2sT3u"
}</pre></div>
        </div>
        <div class="step">
            <p><strong>Simpan token</strong> dari response di atas, lalu sertakan di setiap request:</p>
            <div class="cb"><span class="tag">Header</span><pre>Authorization: Bearer 3|aB4cD5eF6gH7iJ8kL9mN0oP1qR2sT3u</pre></div>
        </div>
        <div class="step">
            <p><strong>Gunakan token</strong> untuk mengakses semua endpoint di bawah ini.</p>
        </div>
    </div>
</div>

<div id="endpoints"></div>

</div>
<script>
const BASE = window.location.origin;
const sections = [
{id:'auth',title:'Authentication',endpoints:[
{m:'POST',url:'/api/login',label:'Login & dapatkan token',params:[
{n:'email',t:'string',r:true},{n:'password',t:'string',r:true},{n:'device_name',t:'string',r:false}
],req:`POST ${BASE}/api/login\nContent-Type: application/json\n\n{\n  "email": "guru@smkmetland.net",\n  "password": "Guru1234"\n}`,
res:`{\n  "message": "Login berhasil",\n  "user": { "id": 5, "name": "Nana Suryana, M.Pd", "roles": [{"name":"Teacher"}] },\n  "token": "5|xYz..."\n}`},
{m:'POST',url:'/api/logout',label:'Hapus token aktif',
req:`POST ${BASE}/api/logout\nAuthorization: Bearer 5|xYz...`,res:`{ "message": "Logout berhasil" }`},
{m:'GET',url:'/api/me',label:'Data user yang sedang login',
req:`GET ${BASE}/api/me\nAuthorization: Bearer 5|xYz...`,
res:`{\n  "user": {\n    "id": 5,\n    "name": "Nana Suryana, M.Pd",\n    "email": "kangnana@smkmetland.net",\n    "roles": [{"name":"Teacher"}],\n    "teacher": { "id": 12, "identification_number": "198301..." },\n    "student": null\n  }\n}`}
]},
{id:'teachers',title:'Teachers (Guru)',endpoints:[
{m:'GET',url:'/api/teachers',label:'Daftar semua guru',filters:['?search=nana','?status=Active','?per_page=10'],
req:`GET ${BASE}/api/teachers?search=nana&per_page=10\nAuthorization: Bearer {token}`,
res:`{\n  "data": [\n    {\n      "id": 12,\n      "identification_number": "198301...",\n      "gender": "Laki-laki",\n      "status": "GTY",\n      "user": { "id": 5, "name": "Nana Suryana, M.Pd", "email": "kangnana@smkmetland.net" },\n      "teaching_assignments": [...],\n      "documents": [...]\n    }\n  ],\n  "current_page": 1,\n  "last_page": 3,\n  "total": 45\n}`},
{m:'GET',url:'/api/teachers/{id}',label:'Detail satu guru',
req:`GET ${BASE}/api/teachers/12\nAuthorization: Bearer {token}`,
res:`{\n  "teacher": {\n    "id": 12,\n    "identification_number": "198301...",\n    "user": { "name": "Nana Suryana, M.Pd" },\n    "teaching_assignments": [\n      { "subject": {"name":"Matematika"}, "classroom": {"name":"X"}, "hours_per_week": 4 }\n    ],\n    "documents": [\n      { "document_type": "KTP", "file_path": "teacher-documents/ktp_nana.pdf" }\n    ]\n  }\n}`},
{m:'GET',url:'/api/teachers/me',label:'Data guru sendiri (yang login)',
req:`GET ${BASE}/api/teachers/me\nAuthorization: Bearer {token}`,
res:`{\n  "teacher": { "id": 12, "user": { "name": "Nana Suryana" }, ... }\n}`}
]},
{id:'students',title:'Students (Siswa)',endpoints:[
{m:'GET',url:'/api/students',label:'Daftar semua siswa',filters:['?classroom_id=1','?expertise_id=2','?academic_year_id=3','?search=nama','?per_page=20'],
req:`GET ${BASE}/api/students?classroom_id=1&per_page=10\nAuthorization: Bearer {token}`,
res:`{\n  "data": [\n    {\n      "id": 1,\n      "identification_number": "252610001",\n      "gender": "Perempuan",\n      "user": { "name": "ABIDAH NAILATUL ADHWA" },\n      "classroom": { "name": "X" },\n      "expertise": { "name": "Perhotelan" }\n    }\n  ],\n  "total": 217\n}`},
{m:'GET',url:'/api/students/{id}',label:'Detail satu siswa',
req:`GET ${BASE}/api/students/1\nAuthorization: Bearer {token}`,
res:`{\n  "student": {\n    "id": 1,\n    "identification_number": "252610001",\n    "user": { "name": "ABIDAH NAILATUL ADHWA", "email": "..." },\n    "classroom": { "name": "X" },\n    "expertise": { "name": "Perhotelan" },\n    "academic_year": { "in": 2025 }\n  }\n}`},
{m:'GET',url:'/api/students/me',label:'Data siswa sendiri',
req:`GET ${BASE}/api/students/me\nAuthorization: Bearer {token}`,
res:`{\n  "student": { "id": 1, "user": { "name": "ABIDAH..." }, ... }\n}`}
]},
{id:'subjects',title:'Subjects (Mata Pelajaran)',endpoints:[
{m:'GET',url:'/api/subjects',label:'Semua mata pelajaran',
req:`GET ${BASE}/api/subjects\nAuthorization: Bearer {token}`,
res:`{\n  "subjects": [\n    { "id": 1, "name": "Bahasa Indonesia" },\n    { "id": 2, "name": "Bahasa Inggris" },\n    { "id": 3, "name": "Matematika" }\n  ]\n}`},
{m:'GET',url:'/api/subjects/{id}',label:'Detail subject',
req:`GET ${BASE}/api/subjects/1\nAuthorization: Bearer {token}`,
res:`{ "subject": { "id": 1, "name": "Bahasa Indonesia" } }`}
]},
{id:'classrooms',title:'Classrooms (Kelas)',endpoints:[
{m:'GET',url:'/api/classrooms',label:'Semua kelas + jumlah siswa',
req:`GET ${BASE}/api/classrooms\nAuthorization: Bearer {token}`,
res:`{\n  "classrooms": [\n    { "id": 1, "name": "X", "students_count": 96 },\n    { "id": 2, "name": "XI", "students_count": 102 },\n    { "id": 3, "name": "XII", "students_count": 88 }\n  ]\n}`},
{m:'GET',url:'/api/classrooms/{id}',label:'Detail kelas + daftar siswa',
req:`GET ${BASE}/api/classrooms/1\nAuthorization: Bearer {token}`,
res:`{\n  "classroom": {\n    "id": 1, "name": "X", "students_count": 96,\n    "students": [\n      { "id": 1, "user": {"name":"ABIDAH..."}, "expertise": {"name":"Perhotelan"} }\n    ]\n  }\n}`}
]},
{id:'academic-years',title:'Academic Years (Tahun Akademik)',endpoints:[
{m:'GET',url:'/api/academic-years',label:'Daftar tahun akademik',
req:`GET ${BASE}/api/academic-years\nAuthorization: Bearer {token}`,
res:`{\n  "academic_years": [\n    { "id": 3, "in": 2025, "out": 2026, "label": "2025 - 2026" },\n    { "id": 2, "in": 2024, "out": 2025, "label": "2024 - 2025" }\n  ]\n}`}
]},
{id:'expertises',title:'Expertises (Jurusan)',endpoints:[
{m:'GET',url:'/api/expertises',label:'Daftar semua jurusan',
req:`GET ${BASE}/api/expertises\nAuthorization: Bearer {token}`,
res:`{\n  "expertises": [\n    { "id": 1, "name": "Perhotelan" },\n    { "id": 2, "name": "PPLG" },\n    { "id": 3, "name": "Akuntansi" }\n  ]\n}`}
]},
{id:'schedule-exams',title:'Schedule Exams (Jadwal Ujian)',endpoints:[
{m:'GET',url:'/api/schedule-exams',label:'Daftar jadwal ujian',filters:['?academic_year_id=3','?category=UTS','?today=true','?upcoming=true'],
req:`GET ${BASE}/api/schedule-exams?today=true\nAuthorization: Bearer {token}`,
res:`{\n  "data": [\n    {\n      "id": 1,\n      "category": "UTS",\n      "type": "Tertulis",\n      "start_date": "2026-03-10",\n      "end_date": "2026-03-14",\n      "subject": { "name": "Matematika" },\n      "teacher": { "user": { "name": "Nana Suryana" } },\n      "classrooms": [{ "name": "X" }]\n    }\n  ]\n}`},
{m:'GET',url:'/api/schedule-exams/{id}',label:'Detail + data absensi',
req:`GET ${BASE}/api/schedule-exams/1\nAuthorization: Bearer {token}`,
res:`{\n  "schedule_exam": {\n    "id": 1,\n    "subject": { "name": "Matematika" },\n    "exam_attendances": [\n      { "student": { "user": { "name": "ABIDAH..." } } }\n    ]\n  }\n}`}
]},
{id:'activity-info',title:'Activity Informations (Info Kegiatan)',endpoints:[
{m:'GET',url:'/api/activity-informations',label:'Daftar kegiatan',filters:['?target_audience=teachers','?search=nama'],
req:`GET ${BASE}/api/activity-informations?target_audience=teachers\nAuthorization: Bearer {token}`,
res:`{\n  "data": [\n    {\n      "id": 1,\n      "name": "Rapat Dinas",\n      "execution_date": "2026-05-20",\n      "execution_place": "Aula Sekolah",\n      "target_audience": "teachers",\n      "user": { "name": "Admin" }\n    }\n  ]\n}`},
{m:'GET',url:'/api/activity-informations/{id}',label:'Detail kegiatan',
req:`GET ${BASE}/api/activity-informations/1\nAuthorization: Bearer {token}`,
res:`{\n  "activity_information": {\n    "id": 1, "name": "Rapat Dinas",\n    "classrooms": [{ "name": "X" }]\n  }\n}`}
]},
{id:'teaching-assignments',title:'Teaching Assignments (Penugasan Mengajar)',endpoints:[
{m:'GET',url:'/api/teaching-assignments',label:'Daftar penugasan',filters:['?teacher_id=12','?subject_id=3','?academic_year_id=3','?classroom_id=1'],
req:`GET ${BASE}/api/teaching-assignments?teacher_id=12\nAuthorization: Bearer {token}`,
res:`{\n  "data": [\n    {\n      "id": 1,\n      "hours_per_week": 4,\n      "teacher": { "user": { "name": "Nana Suryana" } },\n      "subject": { "name": "Matematika" },\n      "classroom": { "name": "X" },\n      "expertise": { "name": "PPLG" },\n      "academic_year": { "in": 2025 }\n    }\n  ]\n}`}
]}
];

// Render nav
const nav=document.getElementById('nav');
sections.forEach(s=>{const a=document.createElement('a');a.href='#'+s.id;a.textContent=s.title;nav.appendChild(a)});

// Render sections
const container=document.getElementById('endpoints');
sections.forEach(s=>{
let html=`<div class="section" id="${s.id}"><div class="section-title">${s.title}</div>`;
s.endpoints.forEach(ep=>{
const mc=ep.m==='GET'?'m-get':'m-post';
html+=`<div class="ep" onclick="this.classList.toggle('open')">
<div class="ep-head"><span class="m ${mc}">${ep.m}</span><span class="url">${ep.url}</span><span class="label">${ep.label}</span><span class="arrow">&#9654;</span></div>
<div class="ep-detail">`;
if(ep.params){html+=`<table class="params"><thead><tr><th>Parameter</th><th>Type</th><th></th></tr></thead><tbody>`;
ep.params.forEach(p=>{html+=`<tr><td><code>${p.n}</code></td><td>${p.t}</td><td>${p.r?'<span class="req">Required</span>':'<span class="opt">Optional</span>'}</td></tr>`});
html+=`</tbody></table>`}
if(ep.filters){html+=`<div class="sub">Filters</div><div class="filter-chips">`;ep.filters.forEach(f=>{html+=`<span class="chip">${f}</span>`});html+=`</div>`}
html+=`<div class="sub">Request</div><div class="cb"><span class="tag">HTTP</span><pre>${ep.req}</pre></div>`;
html+=`<div class="sub">Response</div><div class="cb"><span class="tag">JSON</span><pre>${ep.res}</pre></div>`;
html+=`</div></div>`;
});
html+=`</div>`;
container.innerHTML+=html;
});
</script>
</body>
</html>
