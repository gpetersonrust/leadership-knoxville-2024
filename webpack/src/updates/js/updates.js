import  '../scss/updates.scss';

let update_filter_buttons = [...document.querySelectorAll('.update-filter-button')]
let active_button =  update_filter_buttons[0];
//  forof update_filter_buttons
for (const button of update_filter_buttons) {
    button.addEventListener('click', function () {
        let value = button.dataset.filter;
       let update_items = updates[value];
         active_button.classList.remove('active');
            active_button = button;
            button.classList.add('active');
         generateUpdateCards(update_items, 'update-grid');

        
    });
}
function generateUpdateCards(updates, containerId) {
    var updateCardsContainer = document.getElementById(containerId);
  
    // Clear the container before adding new cards
    updateCardsContainer.innerHTML = '';
  
    updates.forEach(function (update) {
      var updateCard = document.createElement('a');
      updateCard.href = update.permalink;
      updateCard.className = 'update-card';
  
      var thumbnail = document.createElement('div');
      thumbnail.className = 'update-card__thumbnail';
      var thumbnailImage = document.createElement('img');
      thumbnailImage.src = update.thumbnail_url;
      thumbnailImage.alt = update.title;
      thumbnail.appendChild(thumbnailImage);
  
      var title = document.createElement('h4');
      title.className = 'update-card__title';
      title.textContent = update.title;
  
      var date = document.createElement('h5');
      date.className = 'update-card__date';
      date.textContent = update.date;
  
      updateCard.appendChild(thumbnail);
      updateCard.appendChild(title);
      updateCard.appendChild(date);
  
      updateCardsContainer.appendChild(updateCard);
    });
  }