<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak RAB Hari {{ $day->day_name }} - {{ $menuHistory->nomor }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            background: #f9fafb;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px 8px;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .bg-blue { background-color: #00B0F0 !important; color: #000; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .bg-peach { background-color: #F8CBAD !important; color: #000; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .bg-lightblue { background-color: #D9E1F2 !important; color: #000; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        
        .header-btn-group {
            display: flex; gap: 10px; margin-bottom: 20px; justify-content: flex-end;
        }
        .btn {
            border: none; padding: 10px 20px; border-radius: 6px;
            cursor: pointer; font-family: sans-serif; font-weight: bold; font-size: 12px;
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-print { background: #4F46E5; color: white; }
        .btn-print:hover { background: #4338ca; }
        
        .btn-reset { background: #fee2e2; color: #ef4444; border: 1px solid #f87171; }
        .btn-reset:hover { background: #fca5a5; color: white; }

        .btn-add { background: #dcfce7; color: #166534; border: 1px solid #86efac; padding: 4px 10px;}
        .btn-add:hover { background: #bbf7d0; }
        .btn-del { background: #fee2e2; color: #ef4444; border: none; padding: 2px 6px; border-radius: 4px; cursor:pointer;}
        .btn-del:hover { background: #fca5a5; color: white; }

        /* Editable Inputs */
        .editable-input {
            width: 100%;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            padding: 4px 2px;
            font-family: inherit;
            font-size: inherit;
            box-sizing: border-box;
            border-radius: 3px;
        }
        .editable-input:focus {
            outline: 2px solid #4F46E5;
            background: #fff;
            border-color: transparent;
        }
        /* Hidden input arrows */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; margin: 0; 
        }

        .edit-notice {
            background: #fffbeb; border-left: 4px solid #f59e0b; padding: 10px 15px;
            margin-bottom: 20px; font-family: sans-serif; font-size: 13px; color: #92400e;
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: white; }
            .container { padding: 0; box-shadow: none; max-width: 100%; }
            table { width: 100%; margin-top: 5px; }
            th, td { padding: 3px 6px; font-size: 12px; }
            .editable-input { border: none; background: transparent; padding: 0; }
            @page { margin: 1cm; size: A4 portrait;}
        }
    </style>
</head>
<body x-data="rabCalculator()">
    <div class="container">
        <div class="no-print">
            <div class="edit-notice">
                <strong>📝 Mode Penyesuaian (Edit Mode)</strong><br>
                Anda dapat mengubah angka Porsi, QTY, Harga, dan Nama Bahan langsung di dalam tabel sebelum dicetak. Semua total dan selisih akan dihitung secara otomatis!
            </div>
            
            <div class="header-btn-group">
                <button type="button" @click="resetData()" class="btn btn-reset">↺ Kembalikan Semula</button>
                <button type="button" onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
            </div>
        </div>

        <table>
            <tr>
                <td colspan="6" class="text-center font-bold bg-blue" style="font-size: 16px;">
                    SPPG {{ mb_strtoupper($menuHistory->sppg->name ?? 'UNKNOWN SPPG') }}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="text-center font-bold bg-blue" style="font-size: 16px;">
                    YAYASAN {{ mb_strtoupper($menuHistory->sppg->name ?? 'UNKNOWN SPPG') }}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="text-center font-bold bg-peach" style="font-size: 14px;">
                    SIKLUS MENU MINGGU KE-{{ $menuHistory->week_number }} (HARI {{ mb_strtoupper($day->day_name) }})
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: none; padding-top: 15px;">
                    Menu : 
                    @if($day->menu)
                        @php
                            $menuNames = [];
                            if ($day->menu->category == 'packet') {
                                $menuNames[] = $day->menu->name;
                                foreach ($day->menu->components as $comp) {
                                    $menuNames[] = $comp->name;
                                }
                            } else {
                                $menuNames[] = $day->menu->name;
                            }
                        @endphp
                        {{ implode(' + ', $menuNames) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: none; padding-bottom: 10px;">
                    Tanggal/Hari : {{ $day->day_name }}, {{ $day->date->isoFormat('DD MMMM Y') }}
                </td>
            </tr>
            <tr class="bg-lightblue text-center font-bold">
                <th style="width: 35%;">DAFTAR BAHAN</th>
                <th style="width: 10%;">QTY</th>
                <th style="width: 12%;">SATUAN</th>
                <th style="width: 15%;">HARGA BELI (HET)</th>
                <th style="width: 15%;">TOTAL</th>
                <th style="width: 13%;">KETERANGAN</th>
            </tr>
            
            <template x-for="(ing, index) in items" :key="index">
                <tr>
                    <td>
                        <input type="text" x-model="ing.name" class="editable-input text-left">
                    </td>
                    <td>
                        <input type="number" x-model.number="ing.qty" class="editable-input text-center" step="0.01">
                    </td>
                    <td>
                        <input type="text" x-model="ing.unit" class="editable-input text-center">
                    </td>
                    <td>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Rp</span>
                            <input type="number" x-model.number="ing.price" class="editable-input text-right" style="width: 80%">
                        </div>
                    </td>
                    <td class="text-right" x-text="'Rp' + formatRupiah(ing.qty * ing.price)"></td>
                    <td class="text-center relative">
                        <input type="text" x-model="ing.note" class="editable-input text-center">
                        <button type="button" @click="removeItem(index)" class="absolute right-[-30px] top-[5px] btn-del no-print" title="Hapus Bahan">✕</button>
                    </td>
                </tr>
            </template>
            
            <tr class="no-print">
                <td colspan="6" class="text-center" style="border-style: dashed; padding: 10px;">
                    <button type="button" @click="addItem()" class="btn btn-add">+ Tambah Baris Bahan</button>
                </td>
            </tr>
            
            <tr>
                <td colspan="4" class="text-center font-bold">TOTAL</td>
                <td class="text-right font-bold" x-text="'Rp' + formatRupiah(totalBelanja)"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center font-bold">PAGU</td>
                <td class="text-right font-bold" x-text="'Rp' + formatRupiah(pagu)"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center font-bold">SELISIH</td>
                <td class="text-right font-bold" x-text="'Rp' + formatRupiah(selisih)"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center font-bold" style="display: flex; justify-content: center; gap: 5px; border:none; border-right:1px solid #000; padding-top:6px; padding-bottom:6px;">
                    PM Porsi besar ( <input type="number" x-model.number="pmCount" class="editable-input text-center" style="width: 40px; font-weight: bold; border-color: #6366f1;"> x 10.000 )
                </td>
                <td class="text-right font-bold" x-text="'Rp' + formatRupiah(pmCount * 10000)"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center font-bold" style="display: flex; justify-content: center; gap: 5px; border:none;  border-right:1px solid #000; border-top:1px solid #000; padding-top:6px; padding-bottom:6px;">
                    PM Porsi kecil ( <input type="number" x-model.number="pkCount" class="editable-input text-center" style="width: 40px; font-weight: bold; border-color: #6366f1;"> x 8.000 )
                </td>
                <td class="text-right font-bold" x-text="'Rp' + formatRupiah(pkCount * 8000)"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center font-bold" style="border-top: 1px solid #000;">Harga per porsi besar</td>
                <td class="text-right font-bold" style="border-top: 1px solid #000;" x-text="'Rp' + formatRupiah(hargaPM)"></td>
                <td style="border-top: 1px solid #000;"></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center font-bold">Harga per porsi kecil</td>
                <td class="text-right font-bold" x-text="'Rp' + formatRupiah(hargaPK)"></td>
                <td></td>
            </tr>
        </table>
    </div>

    @php
        // Prepare origin data for Alpine
        $originIngredients = $ingredients->map(function($ing) {
            return [
                'name' => $ing['name'],
                'qty' => round($ing['qty'], 2),
                'unit' => $ing['unit'],
                'price' => round($ing['price'], 0),
                'note' => ''
            ];
        })->values()->toArray();
    @endphp

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('rabCalculator', () => ({
                // Store original JSON for resetting
                originIngredientsData: @json($originIngredients),
                originPmCount: {{ $porsiBesar }},
                originPkCount: {{ $porsiKecil }},

                // Reactive state variables
                items: [],
                pmCount: {{ $porsiBesar }},
                pkCount: {{ $porsiKecil }},

                init() {
                    // deep clone to break references
                    this.items = JSON.parse(JSON.stringify(this.originIngredientsData));
                },

                resetData() {
                    if(confirm("Apakah Anda yakin ingin mengembalikan data seperti semula?")) {
                        this.items = JSON.parse(JSON.stringify(this.originIngredientsData));
                        this.pmCount = this.originPmCount;
                        this.pkCount = this.originPkCount;
                    }
                },

                addItem() {
                    this.items.push({ name: '', qty: 0, unit: '', price: 0, note: '' });
                },

                removeItem(index) {
                    if(confirm("Hapus baris ini?")) {
                        this.items.splice(index, 1);
                    }
                },

                // Computed Properties
                get pagu() {
                    return (this.pmCount * 10000) + (this.pkCount * 8000);
                },
                
                get totalBelanja() {
                    return this.items.reduce((sum, ing) => sum + ((parseFloat(ing.qty)||0) * (parseFloat(ing.price)||0)), 0);
                },
                
                get selisih() {
                    return this.pagu - this.totalBelanja;
                },
                
                get totalPortions() {
                    return parseInt(this.pmCount || 0) + parseInt(this.pkCount || 0);
                },
                
                get marginPerPorsi() {
                    return this.totalPortions > 0 ? (this.selisih / this.totalPortions) : 0;
                },
                
                get hargaPM() {
                    return 10000 - this.marginPerPorsi;
                },
                
                get hargaPK() {
                    return 8000 - this.marginPerPorsi;
                },
                
                formatRupiah(num) {
                    return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(num || 0);
                }
            }))
        })
    </script>
</body>
</html>
