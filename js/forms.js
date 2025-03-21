// Jobseeker Form
const jobseekerForm = document.getElementById('jobseeker-form');
if (jobseekerForm) {
    jobseekerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const button = this.querySelector('.form-btn');
        const loader = button.querySelector('.loader-dots');
        button.classList.add('loading'); // Show loader
        button.disabled = true; // Disable button during submission
        loader.style.display = 'inline-block'; // Explicitly show loader

        const formData = new FormData(this);
        fetch('backend/jobseeker.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                alert(data.message);
                if (data.status === 'success') this.reset();
            } catch (error) {
                console.error('Response is not valid JSON:', text);
                alert('An error occurred: Invalid response from server.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while submitting the form: ' + error.message);
        })
        .finally(() => {
            button.classList.remove('loading'); // Hide loader
            loader.style.display = 'none'; // Hide loader explicitly
            button.disabled = false; // Re-enable button
        });
    });
}

// Employer Form
const employerForm = document.getElementById('employer-form');
if (employerForm) {
    employerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const button = this.querySelector('.form-btn');
        const loader = button.querySelector('.loader-dots');
        button.classList.add('loading'); // Show loader
        button.disabled = true; // Disable button during submission
        loader.style.display = 'inline-block'; // Explicitly show loader

        const formData = new FormData(this);
        fetch('backend/employer.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                alert(data.message);
                if (data.status === 'success') this.reset();
            } catch (error) {
                console.error('Response is not valid JSON:', text);
                alert('An error occurred: Invalid response from server.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while submitting the form: ' + error.message);
        })
        .finally(() => {
            button.classList.remove('loading'); // Hide loader
            loader.style.display = 'none'; // Hide loader explicitly
            button.disabled = false; // Re-enable button
        });
    });
}

// Contact Form
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const button = this.querySelector('.form-btn');
        const loader = button.querySelector('.loader-dots');
        button.classList.add('loading'); // Show loader
        button.disabled = true; // Disable button during submission
        loader.style.display = 'inline-block'; // Explicitly show loader

        const formData = new FormData(this);
        fetch('backend/contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                alert(data.message);
                if (data.status === 'success') this.reset();
            } catch (error) {
                console.error('Response is not valid JSON:', text);
                alert('An error occurred: Invalid response from server.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while submitting the form: ' + error.message);
        })
        .finally(() => {
            button.classList.remove('loading'); // Hide loader
            loader.style.display = 'none'; // Hide loader explicitly
            button.disabled = false; // Re-enable button
        });
    });
}