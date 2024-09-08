{{-- <script>
    var awal = @json($awal);
    var akhir = @json($akhir);

    const hariAwal = new Date(awal);
    const hariAkhir = new Date(akhir);

    const option = {
        day: 'numeric',
        month: 'long', // 'long' can be used for the full month name
        year: 'numeric'
    };

    const dateFrom = hariAwal.toLocaleDateString('id-ID', option);
    const dateTo = hariAkhir.toLocaleDateString('id-ID', option);

    console.log(dateTo)
</script> --}}
<script>
    var year = @json($year); // Assuming $year is passed from the controller

    // Format the year for display if needed
    console.log(`Selected Year: ${year}`);
</script>
