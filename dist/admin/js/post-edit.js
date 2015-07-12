    window.onload = function()
    {
    	CKEDITOR.replace( 'post-editor' );

        var categories = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          limit: 10,
          prefetch: {
            url: '/admin/available-categories.php',
            filter: function (list)
            {
              return $.map(list, function (category)
              {
                return { name: category };
              });
            }
          }
        });
     
        categories.initialize();

        var prefilledCategories = $('input[name="js-prefilled-categories"]').val() || '';

        prefilledCategories = prefilledCategories.split(',');
     
        var tagApi = $(".tm-input.tm-input-typeahead").tagsManager({
            prefilled: prefilledCategories,
            hiddenTagListName: 'categories',
        });

        $(".tm-input.tm-input-typeahead").typeahead(null,
        {
          name: 'post-categories',
          displayKey: 'name',
          source: categories.ttAdapter()
        });

        $(".post-edit-form__categories").on('typeahead:select',".tm-input.tm-input-typeahead", function (e, d)
        {
            tagApi.tagsManager("pushTag", d.name);
        });

        function validateSlug()
        {
            var slug = $('input[name="title"]').val();

            slug = slug.replace(/\s/gi, "-");

            slug = slug.replace(/[^a-z0-9\-]/gi, "");

            slug = slug.replace(/\-\-+/gi, "-");

            slug = slug.replace(/^\-+|\-+$/gm,'');

            $('#js-post-slug').text(slug);
            $('input[name="post_slug"]').val(slug);
        }

        if($('#js-post-slug').length)
       {
          validateSlug();
          $('input[name="title"]').on('keyup',validateSlug);
       } 
    }