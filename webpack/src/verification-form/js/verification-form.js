   
form.addEventListener('submit', async (event) => {
    event.preventDefault();
    
   
    let captcha = grecaptcha.getResponse();
    
    if (captcha.length == 0) {
      alert('Please select captcha');
      throw new Error('Please select captcha');
      return;
    }
    
    const fd = new FormData(event.target);
    const params = new URLSearchParams(fd);
 
    let headers = new Headers();
    headers.append('X-WP-Nonce', wp_rest_nonce);
 
    
    try {
      const response = await fetch( api_url, {
         headers,
        method: 'POST',
        body: params
      });
  
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
  
      const data = await response.json();
       if(data?.email) {
        let a_tag = document.createElement('a');
        a_tag.href = `mailto:${data.email}`;
        a_tag.innerText = `Email: ${data.email}`;
        // add style color of  #2f9bb6 to a_tag
        a_tag.style.color = '#2f9bb6';
        // font-size 2rem
        a_tag.style.fontSize = '2rem';
        // delete form 
        form.remove();
        verification_container .appendChild(a_tag);
        // click on a_tag
        a_tag.click();
          

      } else {
        alert( data?.message);
        // send to homepage 
        window.location.href = '/';
  
       }
     
    } catch (error) {
      console.error('Error:', error.message);
      throw new Error(error);
    }
  });
  