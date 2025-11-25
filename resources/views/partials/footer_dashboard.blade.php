<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2025 &copy;</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://www.linkedin.com/in/muhamad-ari-kuncoro/">Muhammad Ari Kuncoro</a></p>
        </div>
    </div>
</footer>
        </div>
    </div>
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>



<!-- Need: Apexcharts -->
<script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>


{{-- JS Global --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- ✅ TEMPAT SCRIPT TAMBAHAN DARI @push --}}
@stack('scripts')

</body>

</html>
