// function:
(function(){

    $('#reply').click(function(e) {
      e.preventDefault();

      $(this).hide();

      $('#reply-container').show(500);
    });

    $('a.message-user').click(function(e) {
      e.preventDefault();

      var messageModal = $('#message-modal');

      messageModal.modal('show');

      var username = (typeof $(e.target).parent('a.message-user').attr('data-username') !== "undefined")
        ? $(e.target).parent('a.message-user').attr('data-username')
        : $(e.target).attr('data-username')

      var subject = (typeof $(e.target).parent('a.message-user').attr('data-subject') !== "undefined")
        ? $(e.target).parent('a.message-user').attr('data-subject')
        : $(e.target).attr('data-subject')

      messageModal.find('#message-form #to').val(username);
      messageModal.find('#message-form #subject').val(subject);


      messageModal.on('shown', function() {
        messageModal.find('#message-form #subject').focus();
      });
    });


    $('.message-select').click(function(e) {
      if ($('input.message-select:checked').length) {
        $('#delete-messages').fadeIn();
      } else {
        $('#delete-messages').fadeOut();
      }
    });


    $('#delete-messages').click(function(e) {
      e.preventDefault();

      var messages = [],
          messageForm = $('#message-actions');

      var message_id = $(e.target).attr('data-message-id');

      if (typeof message_id !== "undefined") {
        messages.push(message_id);
      } else {
        $('.message-select:checked').each(function(index, el) {
          messages.push($(el).val());
        });
      }

      if ( ! confirm('Are you sure you wish to delete ' + ((messages.length == 1) ? 'this message?' : 'these messages?')))
        return false;

      if (messages.length) {
        $.ajax({
          type: 'post',
          url: messageForm.attr('action'),
          data: {
            csrf_token: messageForm.find('input[name=csrf_token]').val(),
            messages: messages
          }
        }).done(function(response) {
          window.location = messageForm.find('#delete-messages').attr('data-redirect');
        });
      }
    });



    $('#message-modal #submit-message').click(function(e) {
      e.preventDefault();

      var messageForm = $('#message-form');
      $('#message-form-spinner').html('<i class="icon-spinner icon-spin icon-large"></i> ');

      var data = {
        csrf_token: messageForm.find('input[name=csrf_token]').val(),
        to:             messageForm.find('#to').val(),
        subject:        messageForm.find('#subject').val(),
        message:        messageForm.find('#message').val(),
      };

      $.ajax({
        type: 'post',
        url: messageForm.attr('action'),
        data: data
      }).done(function(response) {

        $('#message-form-spinner').html('');
        $('#message-form-status').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>' + response.message + '</div>');
        $('#message-modal').modal('hide');

      }).fail(function(response) {

        var message = (response.responseJSON.message !== undefined) ? response.responseJSON.message : 'There was a problem sending your message.';

        $('#message-form-spinner').html('');
        $('#message-status').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' + response.statusText + ':</strong> ' + message + '</div>');

      });
    });

})();
