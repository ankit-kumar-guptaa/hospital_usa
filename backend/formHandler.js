const express = require('express');
const nodemailer = require('nodemailer');
const cors = require('cors');

const app = express();
const PORT = 3000;

// Middleware
app.use(express.json()); // Parse JSON bodies
app.use(express.urlencoded({ extended: true })); // Parse URL-encoded bodies (just in case)
app.use(cors({
    origin: '*', // Allow all origins (for testing); in production, specify your frontend URL
    methods: ['GET', 'POST'], // Explicitly allow POST method
    allowedHeaders: ['Content-Type']
}));

// Nodemailer Transporter Setup (SMTP Configuration)
const transporter = nodemailer.createTransport({
    host: 'smtp.hostinger.com',
    port: 587,
    secure: false,
    auth: {
        user: 'rajiv@greencarcarpool.com',
        pass: 'Rajiv@111@'
    }
});

// Verify SMTP connection
transporter.verify((error, success) => {
    if (error) {
        console.log('SMTP Connection Error:', error);
    } else {
        console.log('SMTP Server is ready to send emails');
    }
});

// Function to send email
const sendEmail = async (formData, formType) => {
    let subject, html;

    console.log(`Processing ${formType} form data:`, formData);

    if (formType === 'jobseeker') {
        subject = 'New Jobseeker Application';
        html = `
            <h2>New Jobseeker Application</h2>
            <p><strong>Full Name:</strong> ${formData.fullName}</p>
            <p><strong>Email:</strong> ${formData.email}</p>
            <p><strong>Phone:</strong> ${formData.phone}</p>
            <p><strong>Desired Role:</strong> ${formData.desiredRole}</p>
        `;
    } else if (formType === 'employer') {
        subject = 'New Employer Inquiry';
        html = `
            <h2>New Employer Inquiry</h2>
            <p><strong>Company Name:</strong> ${formData.companyName}</p>
            <p><strong>Email:</strong> ${formData.email}</p>
            <p><strong>Phone:</strong> ${formData.phone}</p>
            <p><strong>Role Needed:</strong> ${formData.roleNeeded}</p>
        `;
    } else if (formType === 'contact') {
        subject = 'New Contact Message';
        html = `
            <h2>New Contact Message</h2>
            <p><strong>Name:</strong> ${formData.name}</p>
            <p><strong>Email:</strong> ${formData.email}</p>
            <p><strong>Message:</strong> ${formData.message}</p>
        `;
    }

    const mailOptions = {
        from: 'rajiv@greencarcarpool.com',
        to: 'theankitkumarg@gmail.com',
        subject: subject,
        html: html
    };

    try {
        const info = await transporter.sendMail(mailOptions);
        console.log('Email sent successfully:', info.response);
        return { success: true, message: `${formType.charAt(0).toUpperCase() + formType.slice(1)} form submitted successfully!` };
    } catch (error) {
        console.error('Error sending email:', error);
        return { success: false, message: `Error sending email: ${error.message}` };
    }
};

// API Routes for Forms
app.post('/submit-jobseeker', async (req, res) => {
    console.log('Received Jobseeker Form Data:', req.body);
    if (!req.body.fullName || !req.body.email || !req.body.phone || !req.body.desiredRole) {
        return res.status(400).json({ success: false, message: 'All fields are required for Jobseeker form' });
    }
    const result = await sendEmail(req.body, 'jobseeker');
    res.json(result);
});

app.post('/submit-employer', async (req, res) => {
    console.log('Received Employer Form Data:', req.body);
    if (!req.body.companyName || !req.body.email || !req.body.phone || !req.body.roleNeeded) {
        return res.status(400).json({ success: false, message: 'All fields are required for Employer form' });
    }
    const result = await sendEmail(req.body, 'employer');
    res.json(result);
});

app.post('/submit-contact', async (req, res) => {
    console.log('Received Contact Form Data:', req.body);
    if (!req.body.name || !req.body.email || !req.body.message) {
        return res.status(400).json({ success: false, message: 'All fields are required for Contact form' });
    }
    const result = await sendEmail(req.body, 'contact');
    res.json(result);
});

// Test Route to Check Server
app.get('/test', (req, res) => {
    res.json({ message: 'Server is running!' });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});