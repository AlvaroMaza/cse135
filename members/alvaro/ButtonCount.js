class ButtonCount extends HTMLElement {
    constructor() {
      super();
  
      // Create a shadow root
      this.attachShadow({ mode: 'open' });
  
      // Create a button element and add it to the shadow root
      const button = document.createElement('button');
      button.innerHTML = 'Times clicked: <span>0</span>';
      this.shadowRoot.appendChild(button);
  
      // Get the count element from the button and save it to an instance variable
      this.count = button.querySelector('span');
  
      // Add a click event listener to the button element
      button.addEventListener('click', () => {
        // Increment the count and update the count element's text content
        this.count.textContent = parseInt(this.count.textContent) + 1;
        button.innerHTML = `Click me! <span>${newCount}</span>`;
      });
  
      // Style the button count
      const style = document.createElement('style');
      style.textContent = `
        :host {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
        }
  
        :host button {
            font-size: 16px;
            padding: 10px 30px;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            background-image: linear-gradient(to right, #ff8a00, #ff0084, #e60073, #8800b3);
            animation: border-pulse 2s infinite;
            transition: all 0.3s ease;
          }
          
          @keyframes border-pulse {
            0% {
              box-shadow: 0px 0px 0px 0px rgba(255, 138, 0, 1);
            }
            100% {
              box-shadow: 0px 0px 0px 20px rgba(255, 138, 0, 0);
            }
          }
          
          :host button:hover {
            transform: scale(1.1);
          }
          
          :host button:focus {
            outline: none;
          }
      `;
      this.shadowRoot.appendChild(style);
    }
  }
  
  // Define button-count in the custom elements registry
  customElements.define('button-count', ButtonCount);
  
