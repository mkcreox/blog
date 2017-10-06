jQuery(document).ready(function () {
    jQuery("input[name='is_active']").on("change", function () {
        setActive(this);
    });
});

function setActive(self) {
    var $self, postId, val = 0, url;
    $self = jQuery(self);
    postId = $self.data("post-id");
    url = $self.data("url");

    if ($self.is(":checked")) {
        val = 1;
    }

    jQuery.ajax({
        url: url,
        method: 'POST',
        data: {
            is_active: val,
            post_id: postId
        },
        success: function () {
            window.location.reload();
        }
    })
}