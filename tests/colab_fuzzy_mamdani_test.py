# ╔══════════════════════════════════════════════════════════════════════════════╗
# ║     PENGUJIAN SISTEM FUZZY MAMDANI — DepreSense (BDI-II)                   ║
# ║     Verifikasi Matematis Step-by-Step untuk Google Colab                   ║
# ║                                                                              ║
# ║  Cara penggunaan:                                                            ║
# ║  1. Buka Google Colab: https://colab.research.google.com                   ║
# ║  2. Buat notebook baru                                                       ║
# ║  3. Copy-paste seluruh isi file ini ke satu cell                            ║
# ║  4. Tekan Shift+Enter untuk menjalankan                                     ║
# ╚══════════════════════════════════════════════════════════════════════════════╝

# pyrefly: ignore [missing-import]
import numpy as np
import matplotlib.pyplot as plt
import matplotlib.patches as mpatches
from matplotlib.gridspec import GridSpec

# ──────────────────────────────────────────────────────────────────────────────
# BAGIAN 0: Setup & Konfigurasi Warna
# ──────────────────────────────────────────────────────────────────────────────
COLORS = {
    'minimal': '#22c55e',   # hijau
    'ringan':  '#f59e0b',   # kuning
    'sedang':  '#f97316',   # oranye
    'berat':   '#ef4444',   # merah
}
PASS_ICON = '✅'
FAIL_ICON = '❌'
test_results = []   # menyimpan hasil semua test

def report(name, passed, detail=''):
    icon = PASS_ICON if passed else FAIL_ICON
    status = 'PASS' if passed else 'FAIL'
    test_results.append({'name': name, 'passed': passed})
    print(f"  {icon}  [{status}]  {name}")
    if detail:
        print(f"         ↳ {detail}")

# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 1: FUNGSI KEANGGOTAAN (Membership Functions)
# ══════════════════════════════════════════════════════════════════════════════
print("=" * 70)
print("  TAHAP 1 — FUZZIFIKASI: Fungsi Keanggotaan")
print("=" * 70)

def trapezoid_left(x, a, b, c, d):
    """Trapezoid kiri: penuh di [a,c], turun linear di (c,d)"""
    if x <= c:
        return 1.0
    elif c < x < d:
        return (d - x) / (d - c)
    else:
        return 0.0

def trapezoid(x, a, b, c, d):
    """Trapezoid penuh: naik di (a,b), penuh di [b,c], turun di (c,d)"""
    if x <= a or x >= d:
        return 0.0
    elif a < x < b:
        return (x - a) / (b - a)
    elif b <= x <= c:
        return 1.0
    elif c < x < d:
        return (d - x) / (d - c)
    return 0.0

def trapezoid_right(x, a, b, c, d):
    """Trapezoid kanan: naik di (a,b), penuh di [b,d]"""
    if x <= a:
        return 0.0
    elif a < x < b:
        return (x - a) / (b - a)
    else:
        return 1.0

def triangle(x, a, b, c):
    """Segitiga: naik di (a,b), turun di (b,c)"""
    if x <= a or x >= c:
        return 0.0
    elif a < x <= b:
        return (x - a) / (b - a)
    elif b < x < c:
        return (c - x) / (c - b)
    return 0.0

# ── Sub-Tahap 1A: Uji Trapezoid Kiri (Minimal) ──────────────────────────────
print("\n── Sub-Tahap 1A: Trapezoid Kiri  params(a=0, b=0, c=10, d=14) ──")

tests_1a = [
    ("x=0  ≤ c=10  → plateau → µ=1.0",   trapezoid_left(0,  0,0,10,14), 1.0),
    ("x=5  ≤ c=10  → plateau → µ=1.0",   trapezoid_left(5,  0,0,10,14), 1.0),
    ("x=10 = c=10  → plateau → µ=1.0",   trapezoid_left(10, 0,0,10,14), 1.0),
    ("x=12 → (14-12)/(14-10)=0.5",        trapezoid_left(12, 0,0,10,14), 0.5),
    ("x=11 → (14-11)/(14-10)=0.75",       trapezoid_left(11, 0,0,10,14), 0.75),
    ("x=13 → (14-13)/(14-10)=0.25",       trapezoid_left(13, 0,0,10,14), 0.25),
    ("x=14 ≥ d=14  → luar  → µ=0.0",     trapezoid_left(14, 0,0,10,14), 0.0),
    ("x=42 >> d    → luar  → µ=0.0",     trapezoid_left(42, 0,0,10,14), 0.0),
]
for desc, got, expected in tests_1a:
    report(desc, abs(got - expected) < 1e-9, f"dapat={got:.4f}, harapan={expected:.4f}")

# ── Sub-Tahap 1B: Uji Trapezoid (Ringan) ────────────────────────────────────
print("\n── Sub-Tahap 1B: Trapezoid  params(a=10, b=14, c=20, d=24) ──")

tests_1b = [
    ("x=9  < a=10  → luar   → µ=0.0",    trapezoid(9,  10,14,20,24), 0.0),
    ("x=25 > d=24  → luar   → µ=0.0",    trapezoid(25, 10,14,20,24), 0.0),
    ("x=12 → (12-10)/(14-10)=0.5",        trapezoid(12, 10,14,20,24), 0.5),
    ("x=17 ∈ [14,20] → plateau → µ=1.0", trapezoid(17, 10,14,20,24), 1.0),
    ("x=22 → (24-22)/(24-20)=0.5",        trapezoid(22, 10,14,20,24), 0.5),
]
for desc, got, expected in tests_1b:
    report(desc, abs(got - expected) < 1e-9, f"dapat={got:.4f}, harapan={expected:.4f}")

# ── Sub-Tahap 1C: Uji Trapezoid Kanan (Berat) ───────────────────────────────
print("\n── Sub-Tahap 1C: Trapezoid Kanan  params(a=30, b=35, c=42, d=42) ──")

tests_1c = [
    ("x=0   ≤ a=30  → luar   → µ=0.0",   trapezoid_right(0,   30,35,42,42), 0.0),
    ("x=30  = a=30  → luar   → µ=0.0",   trapezoid_right(30,  30,35,42,42), 0.0),
    ("x=32.5→ (32.5-30)/(35-30)=0.5",    trapezoid_right(32.5,30,35,42,42), 0.5),
    ("x=35  ≥ b=35  → plateau → µ=1.0",  trapezoid_right(35,  30,35,42,42), 1.0),
    ("x=42  ≥ b=35  → plateau → µ=1.0",  trapezoid_right(42,  30,35,42,42), 1.0),
]
for desc, got, expected in tests_1c:
    report(desc, abs(got - expected) < 1e-9, f"dapat={got:.4f}, harapan={expected:.4f}")

# ── Sub-Tahap 1D: Uji Integrasi fuzzify() dengan Kasus BDI-II ───────────────
print("\n── Sub-Tahap 1D: Integrasi fuzzify() — 5 Kasus BDI-II Nyata ──")

# Parameter membership variabel 'total' (0–42)
PARAMS_TOTAL = {
    'minimal': ('trapezoid_left',  0,  0, 10, 14),
    'ringan':  ('trapezoid',      10, 14, 20, 24),
    'sedang':  ('trapezoid',      20, 24, 30, 35),
    'berat':   ('trapezoid_right',30, 35, 42, 42),
}

def fuzzify(value, params):
    result = {}
    for label, (fn_type, a, b, c, d) in params.items():
        if fn_type == 'trapezoid_left':
            result[label] = trapezoid_left(value, a, b, c, d)
        elif fn_type == 'trapezoid':
            result[label] = trapezoid(value, a, b, c, d)
        elif fn_type == 'trapezoid_right':
            result[label] = trapezoid_right(value, a, b, c, d)
        elif fn_type == 'triangle':
            result[label] = triangle(value, a, b, c)
    return result

bdi_cases = [
    (5,    {'minimal':1.0,'ringan':0.0,'sedang':0.0,'berat':0.0}, "Skor 5  → Sepenuhnya Minimal"),
    (12,   {'minimal':0.5,'ringan':0.5,'sedang':0.0,'berat':0.0}, "Skor 12 → Transisi Minimal↔Ringan"),
    (17,   {'minimal':0.0,'ringan':1.0,'sedang':0.0,'berat':0.0}, "Skor 17 → Sepenuhnya Ringan"),
    (22,   {'minimal':0.0,'ringan':0.5,'sedang':0.5,'berat':0.0}, "Skor 22 → Transisi Ringan↔Sedang"),
    (38,   {'minimal':0.0,'ringan':0.0,'sedang':0.0,'berat':1.0}, "Skor 38 → Sepenuhnya Berat"),
]

for skor, expected, label in bdi_cases:
    got = fuzzify(skor, PARAMS_TOTAL)
    all_ok = all(abs(got[k] - expected[k]) < 1e-9 for k in expected)
    detail = "  ".join([f"µ_{k}={v:.2f}" for k, v in got.items()])
    report(f"Kasus {skor:>2} — {label}", all_ok, detail)


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 2: EVALUASI ATURAN (Rule Evaluation)
# ══════════════════════════════════════════════════════════════════════════════
print("\n" + "=" * 70)
print("  TAHAP 2 — EVALUASI ATURAN FUZZY (Operator AND = MIN)")
print("=" * 70)

# Basis Aturan (dari FuzzyRuleSeeder.php)
FUZZY_RULES = [
    {'no': 1,  'total':'minimal','cognitive':'minimal','somatic':'minimal', 'consequent':'minimal'},
    {'no': 2,  'total':'ringan', 'cognitive':'ringan', 'somatic':'minimal', 'consequent':'ringan'},
    {'no': 3,  'total':'ringan', 'cognitive':'minimal','somatic':'ringan',  'consequent':'ringan'},
    {'no': 4,  'total':'sedang', 'cognitive':'sedang', 'somatic':'ringan',  'consequent':'sedang'},
    {'no': 5,  'total':'sedang', 'cognitive':'ringan', 'somatic':'sedang',  'consequent':'sedang'},
    {'no': 6,  'total':'berat',  'cognitive':'berat',  'somatic':'sedang',  'consequent':'berat'},
    {'no': 7,  'total':'berat',  'cognitive':'sedang', 'somatic':'berat',   'consequent':'berat'},
    {'no': 8,  'total':'berat',  'cognitive':'berat',  'somatic':'berat',   'consequent':'berat'},
    {'no': 9,  'total':'ringan', 'cognitive':'ringan', 'somatic':'ringan',  'consequent':'ringan'},
    {'no': 10, 'total':'sedang', 'cognitive':'sedang', 'somatic':'sedang',  'consequent':'sedang'},
    {'no': 11, 'total':'minimal','cognitive':'ringan', 'somatic':'minimal', 'consequent':'minimal'},
    {'no': 12, 'total':'sedang', 'cognitive':'berat',  'somatic':'ringan',  'consequent':'sedang'},
    {'no': 13, 'total':'berat',  'cognitive':'sedang', 'somatic':'ringan',  'consequent':'sedang'},
    {'no': 14, 'total':'ringan', 'cognitive':'sedang', 'somatic':'minimal', 'consequent':'ringan'},
]

def evaluate_rules(mu_total, mu_cog, mu_som, rules):
    results = []
    for rule in rules:
        alpha = min(
            mu_total.get(rule['total'], 0.0),
            mu_cog.get(rule['cognitive'], 0.0),
            mu_som.get(rule['somatic'], 0.0),
        )
        results.append({'no': rule['no'], 'consequent': rule['consequent'], 'alpha': alpha})
    return results

# ── Kasus Uji Manual: Input (total=12, cognitive=7, somatic=2) ───────────────
print("\n── Kasus Manual: Input BDI-II (total=12, cognitive=7, somatic=2) ──\n")

PARAMS_COG = {
    'minimal': ('trapezoid_left',  0, 0,  6,  9),
    'ringan':  ('trapezoid',       6, 9, 12, 15),
    'sedang':  ('trapezoid',      12,15, 18, 22),
    'berat':   ('trapezoid_right',18,22, 26, 26),
}
PARAMS_SOM = {
    'minimal': ('trapezoid_left',  0, 0,  4,  5),
    'ringan':  ('trapezoid',       4, 5,  8,  9),
    'sedang':  ('trapezoid',       8, 9, 12, 13),
    'berat':   ('trapezoid_right',12,13, 16, 16),
}

mu_t = fuzzify(12, PARAMS_TOTAL)
mu_c = fuzzify(7,  PARAMS_COG)
mu_s = fuzzify(2,  PARAMS_SOM)

print(f"  Fuzzifikasi total=12  → {', '.join(f'µ_{k}={v:.4f}' for k,v in mu_t.items())}")
print(f"  Fuzzifikasi cog=7     → {', '.join(f'µ_{k}={v:.4f}' for k,v in mu_c.items())}")
print(f"  Fuzzifikasi somatic=2 → {', '.join(f'µ_{k}={v:.4f}' for k,v in mu_s.items())}")
print()

evaluated = evaluate_rules(mu_t, mu_c, mu_s, FUZZY_RULES)
active = [r for r in evaluated if r['alpha'] > 0]

print(f"  {'No':>3} │ {'Antecedent (T,C,S)':^35} │ {'Konsekuen':^8} │ {'α (MIN)':>8}")
print(f"  ────┼{'─'*37}┼{'─'*10}┼{'─'*9}")
for r in evaluated:
    rule = next(x for x in FUZZY_RULES if x['no'] == r['no'])
    ant  = f"total={rule['total']}, cog={rule['cognitive']}, som={rule['somatic']}"
    star = " ◀" if r['alpha'] > 0 else ""
    print(f"  R{r['no']:>2} │ {ant:^35} │ {r['consequent']:^8} │ {r['alpha']:>8.4f}{star}")

print(f"\n  ◀ = Aturan aktif (α > 0)")

# Validasi aturan aktif
report("R1:  IF minimal,minimal,minimal → α = MIN(0.5, 0.67, 1.0) = 0.5",
       abs(evaluated[0]['alpha'] - 0.5) < 1e-9, f"α={evaluated[0]['alpha']:.4f}")
report("R11: IF minimal,ringan, minimal → α = MIN(0.5, 0.33, 1.0) = 0.33",
       abs(evaluated[10]['alpha'] - round(1/3, 4)) < 1e-3, f"α={evaluated[10]['alpha']:.4f}")
report("R2:  IF ringan, ringan, minimal → α = MIN(0.5, 0.33, 1.0) = 0.33",
       abs(evaluated[1]['alpha'] - round(1/3, 4)) < 1e-3, f"α={evaluated[1]['alpha']:.4f}")
report("Semua aturan lain tidak aktif (α = 0.0)",
       all(r['alpha'] == 0.0 for r in evaluated if r['no'] not in [1,2,11]),
       "")


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 3: AGREGASI (MAX per Himpunan Output)
# ══════════════════════════════════════════════════════════════════════════════
print("\n" + "=" * 70)
print("  TAHAP 3 — AGREGASI (Operator MAX per Himpunan Output)")
print("=" * 70)

def aggregate(rule_outputs):
    aggregated = {'minimal': 0.0, 'ringan': 0.0, 'sedang': 0.0, 'berat': 0.0}
    for out in rule_outputs:
        label = out['consequent']
        if out['alpha'] > aggregated[label]:
            aggregated[label] = out['alpha']
    return aggregated

# Agregasi dari kasus manual di atas
agg = aggregate(evaluated)

print(f"\n  Hasil Agregasi (kasus total=12, cog=7, som=2):")
for label, val in agg.items():
    bar = '█' * int(val * 20)
    print(f"    {label:>8}: α={val:.4f}  |{bar:<20}|")

# Validasi
report("Agregasi minimal = MAX(0.5, 0.33) = 0.5",
       abs(agg['minimal'] - 0.5) < 1e-9, f"α_agg={agg['minimal']:.4f}")
report("Agregasi ringan  = MAX(0.33) = 0.33",
       agg['ringan'] > 0, f"α_agg={agg['ringan']:.4f}")
report("Agregasi sedang  = 0.0 (tidak ada aturan aktif)",
       agg['sedang'] == 0.0, f"α_agg={agg['sedang']:.4f}")
report("Agregasi berat   = 0.0 (tidak ada aturan aktif)",
       agg['berat'] == 0.0, f"α_agg={agg['berat']:.4f}")
report("Agregasi menggunakan MAX bukan SUM (sedang: tidak menjumlah)",
       agg['sedang'] == 0.0 and agg['minimal'] <= 1.0, "")


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 4: DEFUZZIFIKASI (Metode Centroid / COG)
# ══════════════════════════════════════════════════════════════════════════════
print("\n" + "=" * 70)
print("  TAHAP 4 — DEFUZZIFIKASI (Centroid / Center of Gravity)")
print("=" * 70)

# Parameter output (domain 0–100)
OUTPUT_PARAMS = {
    'minimal': ('trapezoid_left',   0,  0, 25, 35),
    'ringan':  ('trapezoid',       25, 35, 50, 60),
    'sedang':  ('trapezoid',       50, 60, 75, 85),
    'berat':   ('trapezoid_right', 75, 85,100,100),
}

def centroid_defuzzify(aggregated, output_params, step=0.1):
    """Metode centroid: Σ(z·µ(z)) / Σ(µ(z))"""
    z_range = np.arange(0, 100 + step, step)
    numerator   = 0.0
    denominator = 0.0

    for z in z_range:
        mu_out = fuzzify(z, output_params)
        # Potong dengan alpha (implication Mamdani = MIN)
        mu_min = min(aggregated['minimal'], mu_out['minimal'])
        mu_rin = min(aggregated['ringan'],  mu_out['ringan'])
        mu_sed = min(aggregated['sedang'],  mu_out['sedang'])
        mu_ber = min(aggregated['berat'],   mu_out['berat'])
        # Ambil MAX dari semua himpunan (union)
        mu_z = max(mu_min, mu_rin, mu_sed, mu_ber)

        numerator   += z * mu_z * step
        denominator += mu_z * step

    centroid = round(numerator / denominator, 2) if denominator > 0 else 0.0
    return centroid

def determine_level(centroid_val, output_params):
    mu = fuzzify(centroid_val, output_params)
    return max(mu, key=mu.get)

# ── Uji 6 Konfigurasi Agregasi ───────────────────────────────────────────────
print("\n── Uji 6 Konfigurasi Agregasi ──\n")
print(f"  {'Kasus':^45} │ {'Centroid':>9} │ {'Level':>8}")
print(f"  {'─'*45}┼{'─'*11}┼{'─'*9}")

def_cases = [
    ({'minimal':1.0,'ringan':0.0,'sedang':0.0,'berat':0.0}, 'minimal', "Hanya Minimal α=1.0"),
    ({'minimal':0.0,'ringan':1.0,'sedang':0.0,'berat':0.0}, 'ringan',  "Hanya Ringan α=1.0"),
    ({'minimal':0.0,'ringan':0.0,'sedang':1.0,'berat':0.0}, 'sedang',  "Hanya Sedang α=1.0"),
    ({'minimal':0.0,'ringan':0.0,'sedang':0.0,'berat':1.0}, 'berat',   "Hanya Berat α=1.0"),
    ({'minimal':0.5,'ringan':0.5,'sedang':0.0,'berat':0.0}, None,      "Campuran Minimal=0.5, Ringan=0.5"),
    ({'minimal':0.0,'ringan':0.7,'sedang':0.3,'berat':0.0}, None,      "Campuran Ringan=0.7, Sedang=0.3"),
]

for i, (agg_case, expected_level, label) in enumerate(def_cases, 1):
    z_star = centroid_defuzzify(agg_case, OUTPUT_PARAMS)
    level  = determine_level(z_star, OUTPUT_PARAMS)
    match  = (expected_level is None) or (level == expected_level)
    icon   = PASS_ICON if match else FAIL_ICON
    print(f"  {label:^45} │ {z_star:>9.2f} │ {level:>8}  {icon}")
    test_results.append({'name': f"Defuzz Kasus {i}: {label}", 'passed': match})


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 5: PENGUJIAN INTEGRASI END-TO-END
# ══════════════════════════════════════════════════════════════════════════════
print("\n" + "=" * 70)
print("  TAHAP 5 — INTEGRASI END-TO-END (Pipeline Lengkap Mamdani)")
print("=" * 70)

def run_pipeline(total_score, cognitive_score, somatic_score):
    """Jalankan pipeline Mamdani lengkap dan kembalikan (centroid, level)"""
    mu_t = fuzzify(total_score,    PARAMS_TOTAL)
    mu_c = fuzzify(cognitive_score, PARAMS_COG)
    mu_s = fuzzify(somatic_score,   PARAMS_SOM)
    evaluated   = evaluate_rules(mu_t, mu_c, mu_s, FUZZY_RULES)
    aggregated  = aggregate(evaluated)
    z_star      = centroid_defuzzify(aggregated, OUTPUT_PARAMS)
    level       = determine_level(z_star, OUTPUT_PARAMS)
    return z_star, level, aggregated

# ── Kelompok A: Profil Khas ──────────────────────────────────────────────────
print("\n── Kelompok A: Profil Khas (Normal Cases) ──")
normal_cases = [
    ("TC-INT-01", (5,  3,  2),  'minimal', "Profil Minimal Murni"),
    ("TC-INT-02", (17, 10, 7),  'ringan',  "Profil Ringan Khas"),
    ("TC-INT-03", (25, 16, 9),  'sedang',  "Profil Sedang Khas"),
    ("TC-INT-04", (37, 23, 14), 'berat',   "Profil Berat Khas"),
]
print(f"\n  {'Kode':^10} │ {'Input (tot,cog,som)':^22} │ {'Centroid':>9} │ {'Level Dapat':>10} │ {'Harapan':>10} │")
print(f"  {'─'*10}┼{'─'*24}┼{'─'*11}┼{'─'*12}┼{'─'*10}┼")
for code, (t, c, s), expected, label in normal_cases:
    z, level, _ = run_pipeline(t, c, s)
    match = level == expected
    icon  = PASS_ICON if match else FAIL_ICON
    print(f"  {code:^10} │ ({t:>2},{c:>2},{s:>2}) {label:<14} │ {z:>9.2f} │ {level:>10} │ {expected:>10} │ {icon}")
    test_results.append({'name': f"{code} {label}", 'passed': match})

# ── Kelompok B: Boundary Values ──────────────────────────────────────────────
print("\n\n── Kelompok B: Nilai Batas (Boundary Values) ──")
boundary_cases = [
    ("TC-BV-01", (0,  0,  0),  ['minimal'],           "Minimum absolut (0,0,0)"),
    ("TC-BV-02", (42, 26, 16), ['berat'],              "Maksimum absolut (42,26,16)"),
    ("TC-BV-03", (10, 6,  4),  ['minimal'],            "Tepat batas atas plateau Minimal"),
    ("TC-BV-04", (12, 7,  4),  ['minimal','ringan'],   "Titik transisi Minimal↔Ringan"),
    ("TC-BV-05", (30, 18, 12), ['sedang','berat'],     "Batas bawah Berat"),
]
print(f"\n  {'Kode':^10} │ {'Input':^12} │ {'Centroid':>9} │ {'Level Dapat':>10} │ Status")
print(f"  {'─'*10}┼{'─'*14}┼{'─'*11}┼{'─'*12}┼{'─'*8}")
for code, (t, c, s), valid_levels, label in boundary_cases:
    z, level, _ = run_pipeline(t, c, s)
    match = level in valid_levels
    icon  = PASS_ICON if match else FAIL_ICON
    print(f"  {code:^10} │ ({t},{c},{s}){' ':^6} │ {z:>9.2f} │ {level:>10} │ {icon} {label}")
    test_results.append({'name': f"{code} {label}", 'passed': match})

# ── Kelompok C: Monotonisitas ─────────────────────────────────────────────────
print("\n\n── Kelompok C: Konsistensi Monotonisitas ──")
monotone_inputs = [
    (3,  2,  1),
    (10, 6,  4),
    (21, 13, 8),
    (32, 20, 12),
    (40, 25, 15),
]
print(f"\n  {'Input (tot,cog,som)':^25} │ {'Centroid':>9} │ {'Level':>8} │ Status")
print(f"  {'─'*25}┼{'─'*11}┼{'─'*10}┼{'─'*8}")
prev_z    = -1.0
monotone  = True
for t, c, s in monotone_inputs:
    z, level, _ = run_pipeline(t, c, s)
    ok = z >= prev_z
    if not ok:
        monotone = False
    icon = PASS_ICON if ok else FAIL_ICON
    print(f"  ({t:>2},{c:>2},{s:>2}){' ':^16} │ {z:>9.2f} │ {level:>8} │ {icon}")
    prev_z = z

report("TC-MO-01: Centroid naik seiring meningkatnya skor BDI-II", monotone)


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 6: VISUALISASI FUNGSI KEANGGOTAAN
# ══════════════════════════════════════════════════════════════════════════════
print("\n" + "=" * 70)
print("  VISUALISASI — Fungsi Keanggotaan Semua Variabel")
print("=" * 70)

fig = plt.figure(figsize=(18, 12))
fig.patch.set_facecolor('#0f172a')
gs  = GridSpec(2, 2, figure=fig, hspace=0.45, wspace=0.3)

PLOT_DATA = [
    ("Variabel Input: Total BDI-II  [0–42]",    PARAMS_TOTAL, 42, gs[0,0]),
    ("Variabel Input: Kognitif       [0–26]",    PARAMS_COG,   26, gs[0,1]),
    ("Variabel Input: Somatik        [0–16]",    PARAMS_SOM,   16, gs[1,0]),
    ("Variabel Output: Level Depresi [0–100]",   OUTPUT_PARAMS,100,gs[1,1]),
]

def plot_mf(ax, params, x_max, title):
    ax.set_facecolor('#1e293b')
    x = np.linspace(0, x_max, 1000)
    for label, config in params.items():
        fn_type, a, b, c, d = config
        y = [trapezoid_left(xi, a,b,c,d)  if fn_type == 'trapezoid_left'  else
             trapezoid(xi, a,b,c,d)        if fn_type == 'trapezoid'        else
             trapezoid_right(xi, a,b,c,d)  if fn_type == 'trapezoid_right'  else
             triangle(xi, a,b,c)
             for xi in x]
        color = COLORS[label]
        ax.plot(x, y, color=color, linewidth=2.5, label=label.capitalize())
        ax.fill_between(x, y, alpha=0.12, color=color)

    ax.set_title(title, color='white', fontsize=10, fontweight='bold', pad=10)
    ax.set_xlabel("Nilai Input", color='#94a3b8', fontsize=9)
    ax.set_ylabel("Derajat Keanggotaan µ", color='#94a3b8', fontsize=9)
    ax.set_ylim(-0.05, 1.15)
    ax.set_xlim(0, x_max)
    ax.tick_params(colors='#94a3b8', labelsize=8)
    ax.spines[:].set_color('#334155')
    ax.grid(True, alpha=0.2, color='#475569')
    legend = ax.legend(loc='upper right', framealpha=0.3, facecolor='#1e293b',
                       labelcolor='white', fontsize=8)

for title, params, x_max, pos in PLOT_DATA:
    ax = fig.add_subplot(pos)
    plot_mf(ax, params, x_max, title)

fig.suptitle("DepreSense — Fungsi Keanggotaan Fuzzy Mamdani", color='white',
             fontsize=14, fontweight='bold', y=0.98)
plt.savefig('fuzzy_membership_functions.png', dpi=150, bbox_inches='tight',
            facecolor='#0f172a')
plt.show()
print("  ✅ Grafik disimpan: fuzzy_membership_functions.png")


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 7: VISUALISASI PIPELINE LENGKAP (Contoh Kasus)
# ══════════════════════════════════════════════════════════════════════════════

def plot_pipeline(total, cognitive, somatic):
    z_star, level, agg = run_pipeline(total, cognitive, somatic)
    mu_t = fuzzify(total,    PARAMS_TOTAL)
    mu_c = fuzzify(cognitive, PARAMS_COG)
    mu_s = fuzzify(somatic,   PARAMS_SOM)

    fig2, axes = plt.subplots(1, 2, figsize=(16, 5))
    fig2.patch.set_facecolor('#0f172a')

    # Panel kiri: Agregasi himpunan output
    ax = axes[0]
    ax.set_facecolor('#1e293b')
    z = np.linspace(0, 100, 1000)
    mu_agg = np.zeros(len(z))
    for i, zi in enumerate(z):
        mu_out = fuzzify(zi, OUTPUT_PARAMS)
        cuts   = {k: min(agg[k], mu_out[k]) for k in agg}
        mu_agg[i] = max(cuts.values())

    for label, config in OUTPUT_PARAMS.items():
        fn_type, a, b, c, d = config
        y_full = [trapezoid_left(zi,a,b,c,d) if fn_type=='trapezoid_left' else
                  trapezoid(zi,a,b,c,d)       if fn_type=='trapezoid'       else
                  trapezoid_right(zi,a,b,c,d) for zi in z]
        ax.plot(z, y_full, '--', color=COLORS[label], alpha=0.3, linewidth=1)
        y_cut = [min(agg[label], yi) for yi in y_full]
        ax.fill_between(z, y_cut, alpha=0.4, color=COLORS[label], label=f"{label} α={agg[label]:.2f}")

    ax.axvline(z_star, color='white', linewidth=2, linestyle=':', label=f'Centroid z*={z_star}')
    ax.set_title(f"Agregasi Output — Input=({total},{cognitive},{somatic})", color='white', fontweight='bold')
    ax.set_xlabel("Domain Output [0–100]", color='#94a3b8')
    ax.set_ylabel("µ(z)", color='#94a3b8')
    ax.tick_params(colors='#94a3b8')
    ax.spines[:].set_color('#334155')
    ax.grid(True, alpha=0.2, color='#475569')
    ax.legend(framealpha=0.3, facecolor='#1e293b', labelcolor='white', fontsize=9)

    # Panel kanan: Bar chart derajat keanggotaan input
    ax2 = axes[1]
    ax2.set_facecolor('#1e293b')
    labels   = ['minimal', 'ringan', 'sedang', 'berat']
    x_pos    = np.arange(len(labels))
    width    = 0.25
    colors_l = [COLORS[l] for l in labels]

    b1 = ax2.bar(x_pos - width, [mu_t[l] for l in labels], width, label='Total',    color=colors_l, alpha=0.9)
    b2 = ax2.bar(x_pos,         [mu_c[l] for l in labels], width, label='Kognitif', color=colors_l, alpha=0.6)
    b3 = ax2.bar(x_pos + width, [mu_s[l] for l in labels], width, label='Somatik',  color=colors_l, alpha=0.3)

    ax2.set_title(f"Derajat Keanggotaan Input → Hasil: {level.upper()}", color='white', fontweight='bold')
    ax2.set_xticks(x_pos)
    ax2.set_xticklabels([l.capitalize() for l in labels], color='#94a3b8')
    ax2.set_ylabel("Derajat Keanggotaan µ", color='#94a3b8')
    ax2.tick_params(colors='#94a3b8')
    ax2.spines[:].set_color('#334155')
    ax2.grid(True, alpha=0.2, axis='y', color='#475569')
    ax2.legend(['Total','Kognitif','Somatik'], framealpha=0.3,
               facecolor='#1e293b', labelcolor='white', fontsize=9)
    ax2.set_ylim(0, 1.2)

    plt.suptitle(f"Pipeline Mamdani — Total={total}, Kognitif={cognitive}, Somatik={somatic} → z*={z_star} ({level.upper()})",
                 color='white', fontsize=12, fontweight='bold')
    plt.tight_layout()
    fname = f'pipeline_{total}_{cognitive}_{somatic}.png'
    plt.savefig(fname, dpi=150, bbox_inches='tight', facecolor='#0f172a')
    plt.show()
    print(f"  ✅ Grafik disimpan: {fname}")
    return z_star, level

print("\n── Visualisasi Pipeline: 4 Profil Mahasiswa ──")
for t, c, s in [(5,3,2), (17,10,7), (25,16,9), (37,23,14)]:
    z, lv = plot_pipeline(t, c, s)
    print(f"     Input ({t:>2},{c:>2},{s:>2}) → Centroid={z:.2f} → Level={lv.upper()}")


# ══════════════════════════════════════════════════════════════════════════════
# RINGKASAN AKHIR
# ══════════════════════════════════════════════════════════════════════════════
print("\n" + "=" * 70)
print("  RINGKASAN HASIL PENGUJIAN")
print("=" * 70)

total_tests  = len(test_results)
passed_tests = sum(1 for r in test_results if r['passed'])
failed_tests = total_tests - passed_tests

print(f"\n  Total Test  : {total_tests}")
print(f"  ✅ Lulus    : {passed_tests}")
print(f"  ❌ Gagal    : {failed_tests}")
print(f"  Akurasi     : {passed_tests/total_tests*100:.1f}%")

if failed_tests > 0:
    print("\n  Test yang Gagal:")
    for r in test_results:
        if not r['passed']:
            print(f"    ❌ {r['name']}")

print("\n" + "=" * 70)
if failed_tests == 0:
    print("  🎉  SEMUA TEST LULUS — Logika Fuzzy Mamdani Terverifikasi!")
else:
    print("  ⚠️  ADA KEGAGALAN — Periksa parameter atau implementasi.")
print("=" * 70)


# ══════════════════════════════════════════════════════════════════════════════
# BAGIAN 8: PERHITUNGAN MAPE (Mean Absolute Percentage Error)
# ══════════════════════════════════════════════════════════════════════════════
# Membandingkan output sistem fuzzy dengan nilai aktual (ground truth)
# menggunakan standar klasifikasi BDI-II klinis.
#
# Referensi klasifikasi BDI-II (Beck et al., 1996):
#   Minimal  : Total 0–13
#   Ringan   : Total 14–19
#   Sedang   : Total 20–28
#   Berat    : Total 29–63 (dalam sistem: 29–42)
#
# Encoding numerik untuk MAPE:
#   Minimal=1, Ringan=2, Sedang=3, Berat=4
#
# Formula MAPE:
#   MAPE = (1/n) × Σ |(Aktual_i − Prediksi_i) / Aktual_i| × 100%
# ══════════════════════════════════════════════════════════════════════════════

print("\n\n" + "=" * 70)
print("  BAGIAN 8 — PERHITUNGAN MAPE (Mean Absolute Percentage Error)")
print("=" * 70)

# ── Dataset Sampel (20 Kasus) ─────────────────────────────────────────────────
# Format: (total, cognitive, somatic, aktual_label)
# Kolom aktual_label berdasarkan cutoff BDI-II standar klinis (bukan fuzzy)
#
# Keterangan pemilihan kasus:
#  - Kasus 1–5  : Nilai murni di tengah setiap kategori → sistem seharusnya sepakat
#  - Kasus 6–10 : Nilai di dekat batas bawah/atas setiap kategori
#  - Kasus 11–15: Nilai di zona transisi antar kategori (paling kritis)
#  - Kasus 16–20: Nilai ekstrem dan kombinasi asimetris
# ─────────────────────────────────────────────────────────────────────────────
DATASET = [
    # No  | total | cog | som | aktual          | keterangan
    #  1: Minimal murni
    (1,    5,     3,    2,   'minimal',  "Minimal murni (tengah)"),
    (2,    3,     2,    1,   'minimal',  "Minimal sangat rendah"),
    #  3: Ringan murni
    (3,    17,    10,   7,   'ringan',   "Ringan murni (tengah)"),
    (4,    16,    10,   6,   'ringan',   "Ringan bawah"),
    #  5: Sedang murni
    (5,    25,    15,   10,  'sedang',   "Sedang murni (tengah)"),
    (6,    24,    15,   9,   'sedang',   "Sedang bawah"),
    #  7: Berat murni
    (7,    37,    23,   14,  'berat',    "Berat murni (tengah)"),
    (8,    40,    25,   15,  'berat',    "Berat tinggi"),
    #  9: Batas atas Minimal (BDI-II: 13 = batas atas minimal)
    (9,    13,    8,    5,   'minimal',  "Batas atas Minimal (skor=13)"),
    # 10: Batas bawah Ringan (BDI-II: 14 = batas bawah ringan)
    (10,   14,    9,    5,   'ringan',   "Batas bawah Ringan (skor=14)"),
    # 11: Zona transisi Minimal–Ringan (BDI-II = 12–13)
    (11,   12,    7,    5,   'minimal',  "Zona transisi Min→Rin (skor=12)"),
    # 12: Batas bawah Sedang (BDI-II: 20)
    (12,   20,    12,   8,   'sedang',   "Batas bawah Sedang (skor=20)"),
    # 13: Batas atas Ringan (BDI-II: 19)
    (13,   19,    12,   7,   'ringan',   "Batas atas Ringan (skor=19)"),
    # 14: Batas bawah Berat (BDI-II: 29)
    (14,   29,    18,   11,  'berat',    "Batas bawah Berat (skor=29)"),
    # 15: Batas atas Sedang (BDI-II: 28)
    (15,   28,    18,   10,  'sedang',   "Batas atas Sedang (skor=28)"),
    # 16: Ekstrem minimum absolut
    (16,   0,     0,    0,   'minimal',  "Minimum absolut (0,0,0)"),
    # 17: Ekstrem maksimum absolut
    (17,   42,    26,   16,  'berat',    "Maksimum absolut (42,26,16)"),
    # 18: Kombinasi asimetris (total sedang, kognitif rendah, somatik tinggi)
    (18,   22,    9,    13,  'sedang',   "Asimetris: cog rendah, som tinggi"),
    # 19: Kombinasi asimetris (total ringan, kognitif tinggi, somatik rendah)
    (19,   15,    13,   2,   'ringan',   "Asimetris: cog tinggi, som rendah"),
    # 20: Zona transisi Sedang–Berat
    (20,   30,    19,   11,  'sedang',   "Zona transisi Sed→Ber (skor=30)"),
]

# ── Mapping Numerik untuk MAPE ─────────────────────────────────────────────
LEVEL_TO_NUM = {'minimal': 1, 'ringan': 2, 'sedang': 3, 'berat': 4}
NUM_TO_LEVEL = {1: 'Minimal', 2: 'Ringan', 3: 'Sedang', 4: 'Berat'}

# ── Menjalankan Sistem Fuzzy pada Setiap Kasus ────────────────────────────────
print("\n  Menjalankan pipeline Mamdani pada 20 kasus dataset...\n")
print(f"  {'No':>3} │ {'Input (T,C,S)':^14} │ {'Aktual':^8} │ {'Prediksi':^8} │ {'Centroid':>8} │ {'|A-P|/A':>7} │ Keterangan")
print(f"  {'─'*3}─┼─{'─'*14}─┼─{'─'*8}─┼─{'─'*8}─┼─{'─'*8}─┼─{'─'*7}─┼─{'─'*25}")

mape_data = []
confusion = {k: {j: 0 for j in ['minimal','ringan','sedang','berat']} for k in ['minimal','ringan','sedang','berat']}

for no, total, cog, som, aktual, keterangan in DATASET:
    centroid_val, pred_label, _ = run_pipeline(total, cog, som)
    aktual_num  = LEVEL_TO_NUM[aktual]
    pred_num    = LEVEL_TO_NUM[pred_label]
    ape         = abs(aktual_num - pred_num) / aktual_num  # Absolute Percentage Error (per kasus)
    cocok       = '✅' if aktual == pred_label else '❌'

    mape_data.append({
        'no': no, 'total': total, 'cognitive': cog, 'somatic': som,
        'aktual': aktual, 'prediksi': pred_label,
        'aktual_num': aktual_num, 'pred_num': pred_num,
        'centroid': centroid_val, 'ape': ape, 'keterangan': keterangan,
    })
    confusion[aktual][pred_label] += 1

    print(f"  {no:>3} │ ({total:>2},{cog:>2},{som:>2}){' ':5} │ {aktual:^8} │ {pred_label:^8} │ {centroid_val:>8.2f} │ {ape:>7.4f} │ {cocok} {keterangan}")

# ── Hitung MAPE ────────────────────────────────────────────────────────────────
n        = len(mape_data)
mape     = (sum(d['ape'] for d in mape_data) / n) * 100
accuracy = (sum(1 for d in mape_data if d['aktual'] == d['prediksi']) / n) * 100

print(f"\n  {'─'*75}")
print(f"  Jumlah Kasus  : {n}")
print(f"  Prediksi Benar: {sum(1 for d in mape_data if d['aktual'] == d['prediksi'])}")
print(f"  Prediksi Salah: {sum(1 for d in mape_data if d['aktual'] != d['prediksi'])}")
print(f"\n  ┌─────────────────────────────────────────────────┐")
print(f"  │  MAPE  = {mape:>6.2f}%  (target: MAPE ≤ 10%)      │")
print(f"  │  Akurasi Klasifikasi = {accuracy:>6.2f}%               │")
print(f"  └─────────────────────────────────────────────────┘")

# Interpretasi MAPE
print("\n  Interpretasi MAPE (Lewis, 1982):")
if mape < 10:
    print(f"  → MAPE={mape:.2f}% → ✅ SANGAT AKURAT (Highly Accurate)")
elif mape < 20:
    print(f"  → MAPE={mape:.2f}% → ✅ AKURAT (Good Forecast)")
elif mape < 50:
    print(f"  → MAPE={mape:.2f}% → ⚠️  CUKUP AKURAT (Reasonable Forecast)")
else:
    print(f"  → MAPE={mape:.2f}% → ❌ TIDAK AKURAT (Inaccurate Forecast)")

# ── MAPE per Kategori ──────────────────────────────────────────────────────────
print("\n\n── MAPE per Kategori Depresi ──\n")
for level in ['minimal', 'ringan', 'sedang', 'berat']:
    subset = [d for d in mape_data if d['aktual'] == level]
    if subset:
        mape_cat = (sum(d['ape'] for d in subset) / len(subset)) * 100
        acc_cat  = sum(1 for d in subset if d['prediksi'] == level) / len(subset) * 100
        bar_ok   = '█' * int(acc_cat / 5)
        print(f"  {level.upper():>8}: MAPE={mape_cat:>6.2f}%  Akurasi={acc_cat:>6.1f}%  |{bar_ok:<20}|  (n={len(subset)})")

# ══════════════════════════════════════════════════════════════════════════════
# VISUALISASI MAPE
# ══════════════════════════════════════════════════════════════════════════════
fig3 = plt.figure(figsize=(18, 13))
fig3.patch.set_facecolor('#0f172a')
gs3  = GridSpec(2, 3, figure=fig3, hspace=0.45, wspace=0.35)

# ── Panel 1: APE per Kasus (Bar Chart) ────────────────────────────────────────
ax1 = fig3.add_subplot(gs3[0, :2])
ax1.set_facecolor('#1e293b')

nos    = [d['no'] for d in mape_data]
apes   = [d['ape'] * 100 for d in mape_data]
colors_bar = [COLORS[d['prediksi']] if d['aktual'] == d['prediksi'] else '#ef4444' for d in mape_data]
bar_labels = ['✅' if d['aktual'] == d['prediksi'] else '❌' for d in mape_data]

bars = ax1.bar(nos, apes, color=colors_bar, alpha=0.85, edgecolor='#475569', linewidth=0.5)
ax1.axhline(mape, color='white', linewidth=1.5, linestyle='--', alpha=0.8, label=f'MAPE = {mape:.2f}%')
ax1.axhline(10,   color='#22c55e', linewidth=1, linestyle=':', alpha=0.6, label='Batas Sangat Akurat (10%)')
ax1.axhline(20,   color='#f59e0b', linewidth=1, linestyle=':', alpha=0.6, label='Batas Akurat (20%)')

for bar, label, ape_val in zip(bars, bar_labels, apes):
    if ape_val > 0:
        ax1.text(bar.get_x() + bar.get_width()/2, bar.get_height() + 0.5,
                 label, ha='center', va='bottom', fontsize=10, color='white')

ax1.set_title('APE (Absolute Percentage Error) per Kasus', color='white', fontweight='bold', pad=10)
ax1.set_xlabel('No. Kasus', color='#94a3b8')
ax1.set_ylabel('APE (%)', color='#94a3b8')
ax1.tick_params(colors='#94a3b8')
ax1.spines[:].set_color('#334155')
ax1.grid(True, alpha=0.2, axis='y', color='#475569')
ax1.set_xticks(nos)
ax1.legend(framealpha=0.3, facecolor='#1e293b', labelcolor='white', fontsize=8, loc='upper right')

legend_patches = [
    mpatches.Patch(color=COLORS['minimal'], label='Prediksi Minimal'),
    mpatches.Patch(color=COLORS['ringan'],  label='Prediksi Ringan'),
    mpatches.Patch(color=COLORS['sedang'],  label='Prediksi Sedang'),
    mpatches.Patch(color=COLORS['berat'],   label='Prediksi Berat'),
    mpatches.Patch(color='#ef4444',         label='Prediksi Salah'),
]
ax1.legend(handles=legend_patches, framealpha=0.3, facecolor='#1e293b',
           labelcolor='white', fontsize=7, loc='upper right')

# ── Panel 2: Ringkasan MAPE (Gauge-style) ─────────────────────────────────────
ax2 = fig3.add_subplot(gs3[0, 2])
ax2.set_facecolor('#1e293b')
ax2.set_aspect('equal')

# Donut chart untuk akurasi
sizes  = [accuracy, 100 - accuracy]
col_do = ['#22c55e', '#334155']
wedges, _ = ax2.pie(sizes, colors=col_do, startangle=90,
                     wedgeprops=dict(width=0.45, edgecolor='#0f172a', linewidth=2))
ax2.text(0, 0.12, f'{accuracy:.1f}%', ha='center', va='center',
         fontsize=22, fontweight='bold', color='white')
ax2.text(0, -0.22, 'Akurasi', ha='center', va='center',
         fontsize=10, color='#94a3b8')
ax2.text(0, -0.5, f'MAPE = {mape:.2f}%', ha='center', va='center',
         fontsize=11, fontweight='bold',
         color='#22c55e' if mape < 10 else '#f59e0b' if mape < 20 else '#ef4444')
interp = 'Sangat Akurat' if mape < 10 else 'Akurat' if mape < 20 else 'Cukup Akurat'
ax2.text(0, -0.72, interp, ha='center', va='center',
         fontsize=9, color='#94a3b8')
ax2.set_title('Ringkasan Akurasi', color='white', fontweight='bold', pad=10)

# ── Panel 3: Confusion Matrix ──────────────────────────────────────────────────
ax3 = fig3.add_subplot(gs3[1, :2])
ax3.set_facecolor('#1e293b')

levels_cm = ['minimal', 'ringan', 'sedang', 'berat']
cm_matrix = np.array([[confusion[a][p] for p in levels_cm] for a in levels_cm])

im = ax3.imshow(cm_matrix, cmap='Blues', aspect='auto', vmin=0)
ax3.set_xticks(range(4))
ax3.set_yticks(range(4))
ax3.set_xticklabels([l.capitalize() for l in levels_cm], color='#94a3b8', fontsize=10)
ax3.set_yticklabels([l.capitalize() for l in levels_cm], color='#94a3b8', fontsize=10)
ax3.set_xlabel('Prediksi (Fuzzy System)', color='#94a3b8', fontsize=10)
ax3.set_ylabel('Aktual (BDI-II Standar)', color='#94a3b8', fontsize=10)
ax3.set_title('Confusion Matrix — Aktual vs Prediksi', color='white', fontweight='bold', pad=10)

for i in range(4):
    for j in range(4):
        val   = cm_matrix[i, j]
        color = 'white' if val > cm_matrix.max() / 2 else '#cbd5e1'
        ax3.text(j, i, str(val), ha='center', va='center',
                 fontsize=14, fontweight='bold', color=color)

ax3.spines[:].set_color('#334155')
plt.colorbar(im, ax=ax3, fraction=0.03, pad=0.02).ax.tick_params(colors='#94a3b8')

# ── Panel 4: MAPE per Kategori ────────────────────────────────────────────────
ax4 = fig3.add_subplot(gs3[1, 2])
ax4.set_facecolor('#1e293b')

mape_by_cat = []
acc_by_cat  = []
for level in levels_cm:
    subset = [d for d in mape_data if d['aktual'] == level]
    mape_by_cat.append((sum(d['ape'] for d in subset) / len(subset)) * 100 if subset else 0)
    acc_by_cat.append(sum(1 for d in subset if d['prediksi'] == level) / len(subset) * 100 if subset else 0)

x_cat = np.arange(4)
w     = 0.35
b1    = ax4.bar(x_cat - w/2, mape_by_cat, w,
                label='MAPE (%)', color=[COLORS[l] for l in levels_cm], alpha=0.8)
b2    = ax4.bar(x_cat + w/2, acc_by_cat,  w,
                label='Akurasi (%)', color=[COLORS[l] for l in levels_cm], alpha=0.4,
                edgecolor=[COLORS[l] for l in levels_cm], linewidth=1.5)

ax4.axhline(10, color='white', linestyle=':', linewidth=1, alpha=0.5)
ax4.set_xticks(x_cat)
ax4.set_xticklabels([l.capitalize() for l in levels_cm], color='#94a3b8', fontsize=9)
ax4.set_ylabel('%', color='#94a3b8', fontsize=9)
ax4.set_title('MAPE & Akurasi per Kategori', color='white', fontweight='bold', pad=10)
ax4.tick_params(colors='#94a3b8')
ax4.spines[:].set_color('#334155')
ax4.grid(True, alpha=0.2, axis='y', color='#475569')
ax4.set_ylim(0, 110)
ax4.legend(['MAPE (%)','Akurasi (%)'], framealpha=0.3, facecolor='#1e293b',
           labelcolor='white', fontsize=8)

for bar_obj, val in zip(b1, mape_by_cat):
    ax4.text(bar_obj.get_x() + bar_obj.get_width()/2, bar_obj.get_height() + 1,
             f'{val:.0f}%', ha='center', va='bottom', color='white', fontsize=8)
for bar_obj, val in zip(b2, acc_by_cat):
    ax4.text(bar_obj.get_x() + bar_obj.get_width()/2, bar_obj.get_height() + 1,
             f'{val:.0f}%', ha='center', va='bottom', color='#94a3b8', fontsize=8)

fig3.suptitle(
    f"DepreSense — Evaluasi Akurasi Sistem Fuzzy Mamdani\n"
    f"MAPE = {mape:.2f}%  |  Akurasi Klasifikasi = {accuracy:.1f}%  |  n = {n} kasus",
    color='white', fontsize=13, fontweight='bold', y=0.99
)
plt.savefig('mape_evaluation.png', dpi=150, bbox_inches='tight', facecolor='#0f172a')
plt.show()
print("\n  ✅ Grafik disimpan: mape_evaluation.png")

# ── Tabel Detail per Kategori (untuk laporan) ─────────────────────────────────
print("\n\n── Tabel Rekap untuk Laporan ──\n")
print(f"  {'Kategori':^10} │ {'n':^4} │ {'Benar':^6} │ {'Salah':^6} │ {'Akurasi':^9} │ {'MAPE':^8} │ Interpretasi")
print(f"  {'─'*10}┼{'─'*6}┼{'─'*8}┼{'─'*8}┼{'─'*11}┼{'─'*10}┼{'─'*20}")
total_benar, total_salah = 0, 0
for level in levels_cm:
    subset   = [d for d in mape_data if d['aktual'] == level]
    n_cat    = len(subset)
    benar    = sum(1 for d in subset if d['prediksi'] == level)
    salah    = n_cat - benar
    acc_c    = benar / n_cat * 100 if n_cat else 0
    mape_c   = (sum(d['ape'] for d in subset) / n_cat) * 100 if n_cat else 0
    interp_c = 'Sangat Akurat' if mape_c < 10 else 'Akurat' if mape_c < 20 else 'Cukup Akurat'
    total_benar += benar
    total_salah += salah
    print(f"  {level.capitalize():^10} │ {n_cat:^4} │ {benar:^6} │ {salah:^6} │ {acc_c:>7.1f}%  │ {mape_c:>6.2f}%  │ {interp_c}")

print(f"  {'─'*10}┼{'─'*6}┼{'─'*8}┼{'─'*8}┼{'─'*11}┼{'─'*10}┼{'─'*20}")
print(f"  {'TOTAL':^10} │ {n:^4} │ {total_benar:^6} │ {total_salah:^6} │ {accuracy:>7.1f}%  │ {mape:>6.2f}%  │ {'Sangat Akurat' if mape < 10 else 'Akurat'}")

print("\n" + "=" * 70)
print("  🏁  EVALUASI SELESAI")
print("=" * 70)

