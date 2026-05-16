$(function () {

    /* ===== AJAX Filter (index.php) ===== */
    if ($('#blog-grid').length) {

        let filterTimer;

        function fetchBlogs() {
            const search   = $('#search-input').val().trim();
            const category = $('#category-filter').val();
            const date     = $('#date-filter').val();

            $('#loading-spinner').show();
            $('#blog-grid').hide();
            $('#no-results').hide();

            $.ajax({
                url: SITE_URL + '/filter.php',
                method: 'GET',
                data: { search, category, date },
                success: function (html) {
                    $('#loading-spinner').hide();
                    if (html.trim() === '') {
                        $('#no-results').show();
                    } else {
                        $('#blog-grid').html(html).show();
                    }
                },
                error: function () {
                    $('#loading-spinner').hide();
                    $('#blog-grid').html('<div class="col-12"><div class="alert alert-danger">Failed to load blogs. Please try again.</div></div>').show();
                }
            });
        }

        // Debounce search input
        $('#search-input').on('input', function () {
            clearTimeout(filterTimer);
            filterTimer = setTimeout(fetchBlogs, 350);
        });

        // Instant on select change
        $('#category-filter, #date-filter').on('change', fetchBlogs);

        // Initial load
        fetchBlogs();
    }

    /* ===== Admin: confirm delete ===== */
    $(document).on('submit', '.delete-form', function (e) {
        if (!confirm('Are you sure you want to delete this blog?')) {
            e.preventDefault();
        }
    });

    /* ===== Admin: image preview ===== */
    $('#image').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    /* ===== Auto-dismiss alerts ===== */
    setTimeout(function () {
        $('.alert-dismissible').fadeOut(500);
    }, 3500);

});
