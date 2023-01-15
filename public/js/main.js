// JS Document

$(document).ready(function() {
   let toastLiveExample = document.getElementById('liveToast')

   if (toastLiveExample) {
      toastLiveExample.classList.add('show');
   }


   $('.removeTrick').on('click', function(e) {
      e.preventDefault();

      if (confirm('Confirmer-vous la suppression ? Cette action est irréversible.')) {
         let trickPath = $(this).data('route');
         let trickId = $(this).data('id');

         $.ajax({
            url: trickPath,
            type: 'POST',
            success: function (data, status) {
               if (data == true) {
                  $('#trick-' + trickId).remove();
               }
            },
            error: function (xhr, textStatus, errorThrown) {
               console.log('Ajax request failed.');
            }
         });
      }
   });


   $('.removeImg').on('click', function(e) {
      e.preventDefault();

      if (confirm('Confirmer-vous la suppression ? Cette action est irréversible.')) {
         let imagePath = $(this).data('route');
         let imageId = $(this).data('id');

         $.ajax({
            url: imagePath,
            type: 'DELETE',
            success: function (data, status) {
               if (data == true) {
                  $('#image-' + imageId).remove();
               }
            },
            error: function (xhr, textStatus, errorThrown) {
               console.log('Ajax request failed.');
            }
         });
      }
   });


   $('.removeVideo').on('click', function(e) {
      e.preventDefault();

      if (confirm('Confirmer-vous la suppression ? Cette action est irréversible.')) {
         let videoPath = $(this).data('route');
         let videoId = $(this).data('id');

         $.ajax({
            url: videoPath,
            type: 'DELETE',
            success: function (data, status) {
               if (data == true) {
                  $('#video-' + videoId).remove();
               }
            },
            error: function (xhr, textStatus, errorThrown) {
               console.log('Ajax request failed.');
            }
         });
      }
   });
});


$(document).on('click', '#remove_trick_Supprimer', function(e) {
   e.preventDefault();

   if (confirm('Confirmer-vous la suppression ? Cette action est irréversible.')) {
      this.form.submit();
   }
});


$(document).on('click', '#remove_user_Supprimer', function(e) {
   e.preventDefault();

   if (confirm('Confirmer-vous la suppression ? Cette action est irréversible.')) {
      this.form.submit();
   }
});


$(document).on('click', '#edit_trick_video_Valider', function(e) {
   if (!$('li').hasClass('add_video') && $('#edit_trick_video_video_0_url').length == 0) {
      e.preventDefault();
      alert('Veuillez ajouter au moins une vidéo.');
   }
});

const addVideoLink = document.createElement('a')
addVideoLink.classList.add('add_video_list')
addVideoLink.innerText='+ Ajouter vidéo(s)'
addVideoLink.dataset.collectionHolderClass='videos';

const removeVideoLink = document.createElement('a')
removeVideoLink.classList.add('remove_video_list')
removeVideoLink.innerText='- Retirer dernière vidéo'
removeVideoLink.dataset.collectionHolderClass='videos';

const newLinkLi = document.createElement('li').append(addVideoLink);

const collectionHolder = document.querySelector('ul.videos')
collectionHolder.appendChild(addVideoLink);

const addFormToCollection = (e) => {
   const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

   const item = document.createElement('li');

   item.classList.add('add_video');

   item.innerHTML = collectionHolder
       .dataset
       .prototype
       .replace(
           /__name__/g,
           collectionHolder.dataset.index
       );

   collectionHolder.appendChild(item);

   collectionHolder.dataset.index++;

   collectionHolder.appendChild(removeVideoLink);
}

const removeFormToCollection = (e) => {
   if($('.videos').children().last().prev().attr('class') == 'add_video') {
      $('.videos').children().last().prev().remove();
   }

   if($('.videos').children().last().prev().attr('class') != 'add_video') {
      $('.remove_video_list').remove();
   }
}

addVideoLink.addEventListener("click", addFormToCollection);
removeVideoLink.addEventListener("click", removeFormToCollection);
