import '../scss/app.scss'; // Importing SCSS file
 // Get elements with the data-mobile-trim attribute
const mobileTrimElements = document.querySelectorAll('[data-mobile-trim]');

// Check if there are elements to process
if (mobileTrimElements.length) {
  class MobileTrim {
    constructor(element) {
      this.element = element;
      this.trimCount = element.dataset.mobileTrim;
      this.originalText = element.textContent;
      this.mobileText = this.originalText.slice(0, this.trimCount) + '...';
      this.mobileMode = false;
    }

    trim(windowWidth) {
      if ((windowWidth < 768 && !this.mobileMode) || (windowWidth >= 768 && this.mobileMode)) {
        this.element.textContent = this.mobileMode ? this.originalText : this.mobileText;
        this.mobileMode = !this.mobileMode;
      }
    }
  }

  // Create instances of MobileTrim class and store them in an array
  const trim_classes = Array.from(mobileTrimElements, element => new MobileTrim(element));

  // Function to update trimming
  function updateMobileTrim() {
    trim_classes.forEach(element => {
      element.trim(window.innerWidth);
    });
  }

  // Initialize trimming and set up the event listener for window resize
  updateMobileTrim();
  window.addEventListener('resize', updateMobileTrim);
}


class Mobile_Menu_Handler{
  constructor(){
    this.mobile_menu_container = document.querySelector('.mobile-menu-container');
    this.menu = document.getElementById('mobile-menu');
    this.parent_lis = this.menu.querySelectorAll('.menu-item-has-children');
     this.parent_lis.forEach(li => {
       let toggle = this.createToggleElement();
        let link  = li.querySelector('a');
        // clone link 
        let clone = link.cloneNode(true);
        // link.remove()
        let span = document.createElement('span');
        span.classList.add('mobile-menu-item');
        span.appendChild(clone);
        span.appendChild(toggle);
        // span replace link
        li.replaceChild(span, link);
        this.hamburger_menu = document.getElementById('hamburger-menu');
        this.events();

        
     });
  }

  events(){
    this.hamburger_menu.addEventListener('click',  this.toggle_hamburger_menu.bind(this));
  }
 toggle_submenu(){
    this.menu.classList.toggle('hidden');
  }

  createToggleElement(){
    let toggle = document.createElement('div');
    let svg = this.createSVG();
   
    toggle.classList.add('toggle');
    toggle.appendChild(svg);

    toggle.addEventListener('click', this.toggle_submenu.bind(this));
    return toggle;
  }

  createSVG() {
//  <i class="x-anchor-sub-indicator" data-x-skip-scroll="true" aria-hidden="true" data-x-icon-s=""></i>
let  i = document.createElement('i');
i.setAttribute('aria-hidden', 'true');
i.setAttribute('data-x-icon-s', '');
i.classList.add('x-anchor-sub-indicator');
i.classList.add('icon');


    return i;
  }
  
 toggle_submenu(e){
    e.preventDefault();
     let element = e.target.closest('.toggle');
      element.classList.toggle('open');
      let parent = element.parentNode.parentNode;
        let children = parent.querySelector('.sub-menu');
      children.classList.toggle('visible');

     
  }

  toggle_hamburger_menu(e){
    let element = e.target.closest('.hamburger-menu');
    let open_or_close_state = element.classList.contains('open') ? 'closed' : 'open';
    let new_class = `hamburger-menu ${open_or_close_state}`;
    element.setAttribute('class', new_class);

    if(open_or_close_state === 'open'){
      this.mobile_menu_container.classList.add('visible');
    } else {
      this.mobile_menu_container.classList.remove('visible');
    }
  }

}


let mobile_menu_handler = new Mobile_Menu_Handler();