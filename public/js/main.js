// JS Document

$(document).ready(function() {
   let toastLiveExample = document.getElementById('liveToast')

   if (toastLiveExample) {
      toastLiveExample.classList.add('show');
   }


   $('.removeImg').on('click', function(event){
      let imagePath = $(this).data('route');
      let imageId = $(this).data('id');

      $.ajax({
         url: imagePath,
         type: 'DELETE',
         success: function(data, status) {
            if (data == true) {
               $('#image-'+imageId).remove();
            }
         },
         error : function(xhr, textStatus, errorThrown) {
            console.log('Ajax request failed.');
         }
      });
   });


   $('.removeVideo').on('click', function(event){
      let videoPath = $(this).data('route');
      let videoId = $(this).data('id');

      $.ajax({
         url: videoPath,
         type: 'DELETE',
         success: function(data, status) {
            if (data == true) {
               $('#video-'+videoId).remove();
            }
         },
         error : function(xhr, textStatus, errorThrown) {
            console.log('Ajax request failed.');
         }
      });
   });


   $('.removeTrick').on('click', function(event){
      let trickPath = $(this).data('route');
      let trickId = $(this).data('id');

      $.ajax({
         url: trickPath,
         type: 'POST',
         success: function(data, status) {
            if (data == true) {
               $('#trick-'+trickId).remove();
            }
         },
         error : function(xhr, textStatus, errorThrown) {
            console.log('Ajax request failed.');
         }
      });
   });
});


const addVideoLink = document.createElement('a')
addVideoLink.classList.add('add_video_list')
addVideoLink.innerText='+ Ajouter vidéo(s)'
addVideoLink.dataset.collectionHolderClass='videos'

const newLinkLi = document.createElement('li').append(addVideoLink)

const collectionHolder = document.querySelector('ul.videos')
collectionHolder.appendChild(addVideoLink)

const addFormToCollection = (e) => {
   const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

   const item = document.createElement('li');

   item.innerHTML = collectionHolder
       .dataset
       .prototype
       .replace(
           /__name__/g,
           collectionHolder.dataset.index
       );

   collectionHolder.appendChild(item);

   collectionHolder.dataset.index++;
}

addVideoLink.addEventListener("click", addFormToCollection)

/*if(document.getElementById("resetForm")) {
   const resetForm = document.getElementById("resetForm");

   resetForm.addEventListener("click", function(event) {
      let conf = confirm("Confirmer-vous la suppression ? Cette action est irréversible.");

      if(conf == true) {
         // We validate the sending of the form
         this.form.submit();
      }
   });
}*/
