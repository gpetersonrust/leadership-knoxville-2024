class AlumniFilterController {
    constructor(screen_version_class, mobile_version = false) {
        // DOM Elements
        this.screen_version_class = document.getElementById(screen_version_class);
        this.alumniContainer = this.screen_version_class.querySelector('.leadership-alumni');
        this.school_filter = this.screen_version_class.querySelector('#school-filter');
        this.no_school_filter = this.screen_version_class.querySelector('#no-school-filter');
        this.filterButtons = [...this.screen_version_class.querySelectorAll('.alumni-filter-button')];
        this.filterModeButtons = [...this.screen_version_class.querySelectorAll('.alumni-filter-mode-button')];
        this.pageLogo = this.screen_version_class.querySelector('#page-logo').querySelector('img');
        this.alumniContainer = this.screen_version_class.querySelector('.leadership-alumni');
        this.previous_active_button = this.screen_version_class.querySelector('.alumni-filter-button.active');
        this.previous_active_mode_button = this.screen_version_class.querySelector('.alumni-filter-mode-button.active');
        this.school_filter = this.screen_version_class.querySelector('.School');

       this.mobile_version = mobile_version;

        // Variables
        this.filterMode = 'Year';
        this.filterGroup = "flagship-program";
        this.filteredAlumni = [];
        this.alumnis = [];
        this.isNoSchoolFilter = true;
        

        // Logos for different filter groups
        this.logos = {
            'flagship-program': `${site_url}/wp-content/uploads/2023/10/Lead-Knox-Flagship-RGB.jpg`,
            'youth-leadership-knoxville': `${site_url}/wp-content/uploads/2023/10/Lead-Knox-Youth-RGB.jpg`,
            'introduction-knoxville': `${site_url}/wp-content/uploads/2023/10/Lead-Knox-Intro-RGB.jpg`,
            'leadership-knoxville-scholars': `${site_url}/wp-content/uploads/2023/10/Lead-Knox-Scholars-RGB.jpg`,
            'encore': `${site_url}/wp-content/uploads/2023/10/Lead-Knox-Encore-RGB.jpg`
        };

        // Event Handling
        this.events();
       this.init();
    } 

    async init(){
        // Display the spinner
        this.displaySpinner();
        await this.fetchAlumniData(this.filterGroup);
         
        this.filterAlumni();

    }


    screen_size_mode_handler(){
        // screen sizes are as followed 480, 767, 1200, 1800
        let mode = 'mobile';
        let rows = 1;
        if(window.innerWidth >= 480 && window.innerWidth < 767){
            mode = 'tablet';
        } else if(window.innerWidth >= 767 && window.innerWidth < 1200){
            mode = 'desktop';
        } else if (window.innerWidth >= 1200 && window.innerWidth < 1800 ||  window.innerWidth >= 1800){
            mode = 'large-desktop';
        }  

        if(mode == 'mobile'){
            rows = 2;
        }
        if(mode == 'tablet'){
            rows = 2;
        }
        if(mode == 'desktop'){
            rows = 3;
        }
        if(mode == 'large-desktop'){
            rows = 5;
        }

     

         this.screen_size_mode = mode;
            this.screen_size_rows = rows;
      return this;

    }

    // Event listeners setup
    events() {
        this.filterButtons.forEach(button => {
            button.addEventListener('click', async () => {
                // Display the spinner
                this.displaySpinner();

                 
                this.filterGroup = button.id;
                
                
                // Check if alumni data is already fetched
                if (this.alumnis[this.filterGroup] == undefined) {

                    await this.fetchAlumniData(this.filterGroup);
                }
           

                // Handle specific cases for 'youth-leadership-knoxville' filter group
                if (this.filterGroup == 'youth-leadership-knoxville') {
                    this.school_filter.style.display = 'block';

                    if( !this.mobile_version){
                    this.school_filter.previousElementSibling.classList.add('alpha-middle');
                    }
                 
                    

                    this.isNoSchoolFilter = true;
                } else {
                    if (this.isNoSchoolFilter) {
                      
                        this.school_filter.style.display = 'none';
                       
                        this.isNoSchoolFilter = false;
                        if( !this.mobile_version){
                        this.school_filter.previousElementSibling.classList.remove('alpha-middle');
                        }
                       

                      
                        if (this.filterMode == 'School') {
                            this.filterMode = 'Year';
                            this.displayAlumni();
                        }

                       
                    }
                }

                // Update UI
                this.previous_active_button.classList.remove('active');
                button.classList.add('active');
                this.previous_active_button = button;
      
                this.filterAlumni();
            })
        });

        this.filterModeButtons.forEach(button => {

            button.addEventListener('click', () => {

              
                this.filterMode = button.id;
                this.previous_active_mode_button.classList.remove('active');
                button.classList.add('active');
                this.previous_active_mode_button = button;
              
                button.classList.add('active');
                this.filterAlumni();
            })
        });

        // screen resize event that runs the filterAlumni function to update the number of items per row based on the screen size
        window.addEventListener('resize', () => {
            let old_screen_size_mode = this.screen_size_mode;
            if(old_screen_size_mode != this.screen_size_mode_handler().screen_size_mode){
            this.filterAlumni();
            }
        });
    }

    // Function to fetch alumni data
    async fetchAlumniData(alumniProgram) {
        const apiUrl = `${site_url}/wp-json/leadership/v1/alumni`;

        try {
          
            // Encode the alumni program
            alumniProgram = encodeURIComponent(alumniProgram);

            // Construct the URL with the alumni_program parameter
            const url = `${apiUrl}?alumni_program=${alumniProgram}`;

            // Make the GET request
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            // Check if the request was successful
            if (!response.ok) {
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }

            // Parse the JSON response
            const data = await response.json();

            // Access the alumni data
            const alumniData = data.data.alumnis;
            this.alumnis[alumniProgram] = alumniData;

            

        } catch (error) {
            // Handle errors
            console.error('Error fetching alumni data:', error.message);
        }
    }

    // Function to filter alumni based on selected criteria
    filterAlumni() {
       
        this.filteredAlumni = this.alumnis[this.filterGroup];

        if (this.filterMode === 'Year' || this.filterMode === null) {
            this.filteredAlumni = this.groupArrayByYear(this.filteredAlumni);

            // sort by last name  and first name
            for (const year in this.filteredAlumni) {
                if (this.filteredAlumni.hasOwnProperty(year)) {
                    this.filteredAlumni[year] = this.filteredAlumni[year].sort((a, b) => {
                        const lastNameA = a.title.split(" ").reverse()[0];
                        const lastNameB = b.title.split(" ").reverse()[0];

                        if (lastNameA === lastNameB) {
                            // If last names are the same, compare by first name
                            const firstNameA = a.title.split(" ")[0];
                            const firstNameB = b.title.split(" ")[0];
                            return firstNameA.localeCompare(firstNameB);
                        } else {
                            return lastNameA.localeCompare(lastNameB);
                        }
                    });
                }
            }
            
        } else if (this.filterMode === 'Alphabetically') {
            this.filteredAlumni = this.groupArrayAlphabetically(this.filteredAlumni);
        } else if (this.filterMode === 'School') {
            this.filteredAlumni = this.groupArrayBySchool(this.filteredAlumni);

            // Sort the filtered alumni by school name alphabetically
            const ordered = {};
            Object.keys(this.filteredAlumni).sort().forEach(function (key) {
                ordered[key] = this.filteredAlumni[key];
            }, this);

            this.filteredAlumni = ordered;
        } else {
            this.filteredAlumni = this.groupArrayByYear(this.filteredAlumni);
        }

        this.displayAlumni();
    }

    // Function to display alumni on the webpage
    displayAlumni() {
     

        // Clear the existing content
        this.alumniContainer.innerHTML = '';
        let items_per_row;    

  

        // Loop through the filtered alumni and display them
        for (const year in this.filteredAlumni) {
            if (this.filteredAlumni.hasOwnProperty(year)) {
                
                const yearGroup = this.filteredAlumni[year];
                const itemsLength = yearGroup.length;
                items_per_row = itemsLength <  12 ? 12:  Math.ceil(itemsLength / this.screen_size_mode_handler().screen_size_rows ) ;
                
 

                // Create year element
                const yearElement = document.createElement('h2');
                yearElement.classList.add('leadership-alumni__year');
                yearElement.textContent = year;

                // Create row element
                const rowElement = document.createElement('div');
                rowElement.classList.add('leadership-alumni__row');
                let columnElement = document.createElement('div');
                columnElement.classList.add('leadership-alumni__column');

                let i = 0;

                // Loop through alumni in the year group and create elements for each
                yearGroup.forEach(item => {
                    if (i % items_per_row === 0) {
                        // Create a new column every 7 items
                        if (columnElement.children.length > 0) {
                            rowElement.appendChild(columnElement.cloneNode(true));
                        }
                        columnElement = document.createElement('div');
                        columnElement.classList.add('leadership-alumni__column');
                    }

                    // Create item element
                    const itemElement = document.createElement('li');
                    itemElement.classList.add('leadership-alumni__item');

                    // Create title element
                    const titleElement = document.createElement('span');
                    titleElement.classList.add('leadership-alumni__title');

                    let deceased = item.deceased;

                    // Add 'deceased' class for deceased alumni
                    if (deceased == 'Yes') {
                        titleElement.classList.add('deceased');
                    }

                    titleElement.textContent = item.title.replace("&#8217;", "'") + (deceased && " †");

                    // Create year element for alphabetically and school filters
                    const yearElement = document.createElement('span');
                    if (this.filterMode == 'Alphabetically' || this.filterMode == 'School') {
                        yearElement.classList.add('leadership-alumni__year');
                        yearElement.textContent = `(${item.year})`;
                    }

                    // Append elements to item element
                    itemElement.appendChild(titleElement);
                    (this.filterMode == 'Alphabetically' || this.filterMode == 'School') && itemElement.appendChild(yearElement);

                    // Append item element to column element
                    columnElement.appendChild(itemElement);

                    i++;
                });

                // Append the last column if not empty
                if (columnElement.children.length > 0) {
                    rowElement.appendChild(columnElement);
                }

                // Append year and row elements to the alumni container
               this. alumniContainer.appendChild(yearElement);
               this. alumniContainer.appendChild(rowElement);
            }
        }

        // Update page logo based on the current filter group
        this.pageLogo.src = this.logos[this.filterGroup];
        // Hide the spinner
        this.hideSpinner();
    }

    // Function to group alumni array by year
    groupArrayByYear(data) {
        const result = {};

        data.forEach(item => {
            const year = item.year;

            if (!result[year]) {
                result[year] = [];
            }

            result[year].push(item);
        });

        return result;
    }

    // Function to group alumni array alphabetically by name
    groupArrayAlphabetically(data) {
        const result = {};
    
        data.forEach((item, index) => {
            const name = item.title;
            const firstLetter = name.charAt(0).toUpperCase();
            const lastLetter = name.split(" ").reverse()[0].charAt(0).toUpperCase();
    
            if (!result[lastLetter]) {
                result[lastLetter] = [];
            }
    
            result[lastLetter].push(item);
        });
    
        // Sort the results array keys by alphabet
        const ordered = {};
        Object.keys(result).sort().forEach((key) => {
            // Sort each group by last name first and then first name
            ordered[key] = result[key].sort((a, b) => {
                const lastNameA = a.title.split(" ").reverse()[0];
                const lastNameB = b.title.split(" ").reverse()[0];
    
                if (lastNameA === lastNameB) {
                    // If last names are the same, compare by first name
                    const firstNameA = a.title.split(" ")[0];
                    const firstNameB = b.title.split(" ")[0];
                    return firstNameA.localeCompare(firstNameB);
                } else {
                    return lastNameA.localeCompare(lastNameB);
                }
            });
        });
    
        return ordered;
    }
    // Function to group alumni array by school
    groupArrayBySchool(data) {
        const result = {};

        data.forEach(item => {
            const school = item.school;

            if (!result[school]) {
                result[school] = [];
            }

            result[school].push(item);
        });

        return result;
    }


     // Function to create and display the spinner
     displaySpinner() {
 

        // Clear the existing content
        this.alumniContainer.innerHTML = '';
     
        // Check if the spinner already exists
        if (!this.spinner) {
            this.spinner = document.createElement('div');
            this.spinner.classList.add('spinner-container');

            const spinner = document.createElement('div');
            spinner.classList.add('spinner');

            const loadingText = document.createElement('p');
            loadingText.classList.add('loading-text');
            loadingText.textContent = 'Loading';

            const loadingDots = document.createElement('span');
            loadingDots.id = 'loading-dots';

            loadingText.appendChild(loadingDots);
            this.spinner.appendChild(spinner);
            spinner.appendChild(loadingText);

            // Append the spinner to the alumni container
            this. alumniContainer.appendChild(this.spinner);
        } else {
            // If the spinner already exists, just show it
            this.spinner.style.display = 'flex';
           this. alumniContainer.appendChild(this.spinner);
        }
    }

     // Function to hide the spinner
     hideSpinner() {
        if (this.spinner) {
            // If the spinner exists, hide it
            this.spinner.style.display = 'none';
        }
    }

}

// Initialize the AlumniFilterController
new AlumniFilterController('desktop-sort', false);
new AlumniFilterController('mobile-sort', true);