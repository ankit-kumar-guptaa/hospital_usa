// Initialize AOS
AOS.init({
    duration: 1000,
    once: true
});

// Hamburger Menu Toggle
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.nav');
menuToggle.addEventListener('click', () => {
    nav.classList.toggle('active');
});

// Function to show custom notification
const showNotification = (message, type = 'success') => {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = `notification ${type}`; 
    notification.classList.add('show'); 

    // Auto-hide after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show'); 
    }, 3000);
};

// Function to submit form data to backend
const submitForm = async (url, data) => {
    try {
        console.log('Submitting data to:', url);
        console.log('Form Data:', data);
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = await response.json();
        console.log('Server Response:', result);
        return result;
    } catch (error) {
        console.error('Error submitting form:', error);
        return { success: false, message: `Failed to submit form: ${error.message}` };
    }
};

// Jobseeker Form Submission
const jobseekerForm = document.getElementById('jobseeker-form');
if (jobseekerForm) {
    jobseekerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Jobseeker form submitted');
        const formData = {
            fullName: this.querySelector('input[name="fullName"]').value,
            email: this.querySelector('input[name="email"]').value,
            phone: this.querySelector('input[name="phone"]').value,
            desiredRole: this.querySelector('input[name="desiredRole"]').value
        };
        const result = await submitForm('http://localhost:3000/submit-jobseeker', formData);
        if (result.success) {
            showNotification('Jobseeker form submitted successfully! We will contact you soon.', 'success');
            this.reset();
        } else {
            showNotification(`Error: ${result.message}`, 'error');
        }
    });
} else {
    console.error('Jobseeker form not found');
}

// Employer Form Submission
const employerForm = document.getElementById('employer-form');
if (employerForm) {
    employerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Employer form submitted');
        const formData = {
            companyName: this.querySelector('input[name="companyName"]').value,
            email: this.querySelector('input[name="email"]').value,
            phone: this.querySelector('input[name="phone"]').value,
            roleNeeded: this.querySelector('input[name="roleNeeded"]').value
        };
        const result = await submitForm('http://localhost:3000/submit-employer', formData);
        if (result.success) {
            showNotification('Employer form submitted successfully! We will contact you soon.', 'success');
            this.reset();
        } else {
            showNotification(`Error: ${result.message}`, 'error');
        }
    });
} else {
    console.error('Employer form not found');
}

// Contact Form Submission
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Contact form submitted');
        const formData = {
            name: this.querySelector('input[name="name"]').value,
            email: this.querySelector('input[name="email"]').value,
            message: this.querySelector('textarea[name="message"]').value
        };
        const result = await submitForm('http://localhost:3000/submit-contact', formData);
        if (result.success) {
            showNotification('Contact form submitted successfully! We will get back to you soon.', 'success');
            this.reset();
        } else {
            showNotification(`Error: ${result.message}`, 'error');
        }
    });
} else {
    console.error('Contact form not found');
}