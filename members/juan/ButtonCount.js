
class ButtonCount extends HTMLElement {

    constructor() {
    super();

    // Initial click count set to 0
    this.clickCount = 0;

    // Shadow root
    const shadow = this.attachShadow({ mode: 'open' });

    // Create the button
    const button = document.createElement('button');
    button.textContent = `Times clicked: ${this.clickCount}`;

    // Increase the counter when clicking the button
    button.addEventListener('click', () => {

        this.clickCount++;
        button.textContent = `Times clicked: ${this.clickCount}`;
        
    });

    // Append the button to the shadow root
    shadow.appendChild(button);

    }
}
  
customElements.define('button-count', ButtonCount);