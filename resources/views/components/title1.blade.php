<style>
    .main-title {
        color: #2c3e50;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        display: inline-block;
    }

    .main-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60%;
        height: 3px;
        background: #198754;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
</style>
<div class="text-center mb-5">
    <h2 class="main-title">PENRO Procurement Management System (PPMS)</h2>
    {{-- <h5>(For Alternative Work Arrangement)</h5> --}}
</div>
