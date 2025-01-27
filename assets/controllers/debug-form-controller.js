import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    
    static targets = ['form', 'submit', 'csrf', 'previousCsrfValue', 'currentCsrfValue'];
    
    initialize() {
        this.csrfValues = [];
        this.onChange = this.refresh.bind(this);
    }
    
    connect() {
        this.csrfTarget.addEventListener('change', this.onChange);
        this.refresh();
    }
    
    disconnect() {
        this.csrfTarget.removeEventListener('change', this.onChange);
    }
    
    refresh() {
        const csrfValue = this.csrfTarget.value;
        if (csrfValue !== this.currentCsrfValueTarget.value) {
            if (this.currentCsrfValueTarget.value) {
                this.previousCsrfValueTarget.value = this.currentCsrfValueTarget.value;
            }
            this.currentCsrfValueTarget.value = csrfValue;
        }
    }

}
