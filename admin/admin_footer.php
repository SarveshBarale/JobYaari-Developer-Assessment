    </div><!-- /.admin-content -->
</div><!-- /.admin-main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<script>const SITE_URL = '<?= SITE_URL ?>';</script>
<script>
$('#sidebarToggle').on('click', function () {
    $('#adminSidebar').toggleClass('d-none d-flex');
});
</script>
</body>
</html>
