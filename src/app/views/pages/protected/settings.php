<?php
// filepath: d:\WORKSPACE\WORKSPACE PHP\docker-php-sample\src\app\views\pages\protected\settings.php

// Fetch current settings from database
$siteSettings = [
    'site_name' => 'Car Management System',
    'site_description' => 'Manage your vehicle inventory efficiently',
    'contact_email' => 'contact@example.com',
    'contact_phone' => '(123) 456-7890',
    'contact_address' => '123 Main Street, City, Country',
    'social_facebook' => 'https://facebook.com/carmanagement',
    'social_twitter' => 'https://twitter.com/carmanagement',
    'social_instagram' => 'https://instagram.com/carmanagement',
    'footer_text' => '© 2025 Car Management System. All rights reserved.',
    'maintenance_mode' => false,
];

// Fetch customer contacts (sample data)
$customerContacts = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '(123) 456-7890',
        'message' => 'I\'m interested in the latest model.',
        'status' => 'pending',
        'created_at' => '2025-05-04 10:25:00'
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'phone' => '(234) 567-8901',
        'message' => 'Please send me more information about financing options.',
        'status' => 'responded',
        'created_at' => '2025-05-03 14:30:00'
    ],
    [
        'id' => 3,
        'name' => 'Robert Johnson',
        'email' => 'robert@example.com',
        'phone' => '(345) 678-9012',
        'message' => 'When will the new models be available?',
        'status' => 'closed',
        'created_at' => '2025-05-02 09:15:00'
    ],
];
?>

<style>
    .settings-wrapper {
        display: flex;
        height: calc(100vh - 80px);
    }
    
    .settings-sidebar {
        width: 240px;
        background-color: #f8f9fa;
        border-right: 1px solid #e9ecef;
        padding: 20px 0;
    }
    
    .settings-sidebar-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #5a5a5a;
        font-weight: 500;
        text-decoration: none;
        border-left: 3px solid transparent;
        margin-bottom: 5px;
    }
    
    .settings-sidebar-item:hover {
        background-color: #f0f0f0;
        color: #212529;
    }
    
    .settings-sidebar-item.active {
        background-color: #e9ecef;
        border-left-color: #0d6efd;
        color: #0d6efd;
    }
    
    .settings-sidebar-item i {
        margin-right: 12px;
        width: 20px;
        text-align: center;
    }
    
    .settings-content {
        flex: 1;
        padding: 30px;
        background-color: #ffffff;
        overflow-y: auto;
    }
    
    .settings-section {
        margin-bottom: 40px;
    }
    
    .settings-section-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .settings-section-header i {
        font-size: 1.5rem;
        margin-right: 15px;
        color: #6c757d;
    }
    
    .settings-section-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: #343a40;
    }
    
    .settings-description {
        color: #6c757d;
        margin-bottom: 25px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #495057;
    }
    
    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 5px;
    }
    
    /* Adjust existing styles */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
        background-color: #2196F3;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    
    .caution-box {
        background-color: #fff8e1;
        border-left: 4px solid #ffc107;
        padding: 16px;
        margin-bottom: 24px;
        border-radius: 4px;
    }
    
    .caution-box .icon {
        color: #ffc107;
        margin-right: 10px;
    }
    
    .caution-heading {
        font-weight: 600;
        margin-bottom: 5px;
    }
</style>

<div class="container-fluid p-0">
    <div class="settings-wrapper">
        <!-- Settings Sidebar -->
        <div class="settings-sidebar">
            <a href="#general" class="settings-sidebar-item active">
                <i class="fas fa-cog"></i>
                General
            </a>
            <a href="#contact-info" class="settings-sidebar-item">
                <i class="fas fa-address-card"></i>
                Contact Information
            </a>
            <a href="#social-media" class="settings-sidebar-item">
                <i class="fas fa-share-alt"></i>
                Social Media
            </a>
            <a href="#customer-contacts" class="settings-sidebar-item">
                <i class="fas fa-envelope"></i>
                Customer Inquiries
            </a>
            <a href="#appearance" class="settings-sidebar-item">
                <i class="fas fa-paint-brush"></i>
                Appearance
            </a>
            <a href="#faq" class="settings-sidebar-item">
                <i class="fas fa-question-circle"></i>
                FAQ Management
            </a>
            <a href="#help-questions" class="settings-sidebar-item">
                <i class="fas fa-life-ring"></i>
                Help Questions
            </a>
            <a href="#appointments" class="settings-sidebar-item">
                <i class="fas fa-calendar-check"></i>
                Appointments
            </a>
            <a href="#advanced" class="settings-sidebar-item">
                <i class="fas fa-tools"></i>
                Advanced
            </a>
        </div>
        
        <!-- Settings Content -->
        <div class="settings-content">
            <!-- General Settings -->
            <div class="settings-section" id="general">
                <div class="settings-section-header">
                    <i class="fas fa-cog"></i>
                    <h2 class="settings-section-title">General Settings</h2>
                </div>
                <p class="settings-description">Manage basic website settings</p>
                
                <form id="generalSettingsForm">
                    <div class="form-group">
                        <label for="siteName" class="form-label">Website Name</label>
                        <input type="text" class="form-control" id="siteName" name="site_name" 
                               value="<?= htmlspecialchars($siteSettings['site_name']) ?>">
                        <div class="form-text">This name appears in the browser tab and as the main title.</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="siteDescription" class="form-label">Website Description</label>
                        <textarea class="form-control" id="siteDescription" name="site_description" 
                                  rows="3"><?= htmlspecialchars($siteSettings['site_description']) ?></textarea>
                        <div class="form-text">A brief description of your website. Used for SEO and meta tags.</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="footerText" class="form-label">Footer Text</label>
                        <input type="text" class="form-control" id="footerText" name="footer_text" 
                               value="<?= htmlspecialchars($siteSettings['footer_text']) ?>">
                        <div class="form-text">Text that appears in the footer of all pages.</div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- FAQ Management Section -->
            <div class="settings-section d-none" id="faq">
                <div class="settings-section-header">
                    <i class="fas fa-question-circle"></i>
                    <h2 class="settings-section-title">FAQ Management</h2>
                </div>
                <p class="settings-description">Manage frequently asked questions and their categories</p>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <a href="/faq" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-2"></i>Go to FAQ Management
                        </a>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Quick Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="faqSettingsForm">
                            <div class="form-group d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <label class="form-label mb-0">Show FAQ on Homepage</label>
                                    <p class="form-text mb-0">Display featured FAQs on your homepage</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="show_faq_homepage" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            
                            <div class="form-group d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <label class="form-label mb-0">Enable FAQ Search</label>
                                    <p class="form-text mb-0">Allow users to search through your FAQs</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="enable_faq_search" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="faqsPerPage" class="form-label">FAQs Per Page</label>
                                <select class="form-select" id="faqsPerPage" name="faqs_per_page">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                                <div class="form-text">Number of FAQs to display per page</div>
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    Save FAQ Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Help Questions Section -->
            <div class="settings-section d-none" id="help-questions">
                <div class="settings-section-header">
                    <i class="fas fa-life-ring"></i>
                    <h2 class="settings-section-title">Help Questions</h2>
                </div>
                <p class="settings-description">Manage help questions submitted by users</p>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <a href="/help-question" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-2"></i>Go to Help Questions
                        </a>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Notification Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="helpQuestionsSettingsForm">
                            <div class="form-group d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <label class="form-label mb-0">Email Notifications</label>
                                    <p class="form-text mb-0">Receive email when new help questions are submitted</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="help_email_notifications" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="notificationEmail" class="form-label">Notification Email</label>
                                <input type="email" class="form-control" id="notificationEmail" name="notification_email" 
                                       value="support@example.com">
                                <div class="form-text">Email address to receive notifications</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="autoResponseTemplate" class="form-label">Auto-Response Template</label>
                                <textarea class="form-control" id="autoResponseTemplate" name="auto_response_template" 
                                          rows="4">Thank you for your question. Our team will get back to you within 24 hours.</textarea>
                                <div class="form-text">Template for automatic response emails</div>
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    Save Notification Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Appointments Section -->
            <div class="settings-section d-none" id="appointments">
                <div class="settings-section-header">
                    <i class="fas fa-calendar-check"></i>
                    <h2 class="settings-section-title">Appointments</h2>
                </div>
                <p class="settings-description">Manage test drive and service appointments</p>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <a href="/appointments-management" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-2"></i>Go to Appointments Management
                        </a>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Appointment Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="appointmentsSettingsForm">
                            <div class="form-group">
                                <label for="businessHours" class="form-label">Business Hours</label>
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <label class="form-text">Monday - Friday</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="time" class="form-control" name="weekday_start" value="09:00">
                                            <span class="input-group-text">to</span>
                                            <input type="time" class="form-control" name="weekday_end" value="18:00">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-text">Saturday</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="time" class="form-control" name="saturday_start" value="10:00">
                                            <span class="input-group-text">to</span>
                                            <input type="time" class="form-control" name="saturday_end" value="16:00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="appointmentDuration" class="form-label">Appointment Duration</label>
                                <select class="form-select" id="appointmentDuration" name="appointment_duration">
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60" selected>1 hour</option>
                                    <option value="90">1.5 hours</option>
                                    <option value="120">2 hours</option>
                                </select>
                                <div class="form-text">Default duration for appointments</div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="bufferTime" class="form-label">Buffer Time Between Appointments</label>
                                <select class="form-select" id="bufferTime" name="buffer_time">
                                    <option value="0">None</option>
                                    <option value="15" selected>15 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                </select>
                                <div class="form-text">Time buffer between consecutive appointments</div>
                            </div>
                            
                            <div class="form-group d-flex align-items-center justify-content-between mt-3">
                                <div>
                                    <label class="form-label mb-0">Require Phone Verification</label>
                                    <p class="form-text mb-0">Send verification code via SMS before confirming appointments</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="require_phone_verification">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    Save Appointment Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Advanced Settings (partial example to show the caution box) -->
            <div class="settings-section d-none" id="advanced">
                <div class="settings-section-header">
                    <i class="fas fa-tools"></i>
                    <h2 class="settings-section-title">Advanced Settings</h2>
                </div>
                <p class="settings-description">Configure technical and system settings</p>
                
                <div class="caution-box">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-2x icon"></i>
                        </div>
                        <div>
                            <h6 class="caution-heading">Caution:</h6>
                            <p class="mb-0">These settings can significantly impact how your site functions. Make changes carefully.</p>
                        </div>
                    </div>
                </div>
                
                <form id="advancedSettingsForm">
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <div>
                            <label class="form-label mb-0">Maintenance Mode</label>
                            <p class="form-text mb-0">When enabled, visitors will see a maintenance page instead of your site.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="maintenanceMode" name="maintenance_mode" <?= $siteSettings['maintenance_mode'] ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    
                    <!-- More advanced settings would go here -->
                </form>
            </div>
            
            <!-- Additional tabs would be implemented similarly -->
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle sidebar navigation
    $('.settings-sidebar-item').click(function(e) {
        e.preventDefault();
        
        // Update active state
        $('.settings-sidebar-item').removeClass('active');
        $(this).addClass('active');
        
        // Get the target section
        const targetId = $(this).attr('href');
        
        // Hide all sections and show the target one
        $('.settings-section').addClass('d-none');
        $(targetId).removeClass('d-none');
    });
    
    // Form submission
    $("#generalSettingsForm").submit(function(event) {
        event.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: "/admin/settings/save/general",
            data: formData,
            beforeSend: function() {
                // Show loading state
                $("#generalSettingsForm button[type='submit']").html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
                $("#generalSettingsForm button[type='submit']").prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Settings have been updated successfully');
                } else {
                    toastr.error(response.message || 'Failed to save settings');
                }
            },
            error: function() {
                toastr.error('An error occurred while saving settings');
            },
            complete: function() {
                // Reset button state
                $("#generalSettingsForm button[type='submit']").html('Save Changes');
                $("#generalSettingsForm button[type='submit']").prop('disabled', false);
            }
        });
    });
    
    // Other form submissions would be implemented similarly
});
</script>