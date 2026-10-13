@extends('layouts.app')

@section('page_title', 'V-Tutor | Contact Online Tutors & Tutoring Platform Australia')
@section('meta_description', 'Get in touch with V-Tutor for assistance with online tutoring in Australia. Connect with qualified Maths, Science, and English tutors across the country.')
@section('meta_keywords', 'online tutoring Australia, contact online tutors, Maths tutors, Science tutors, English tutors, qualified tutors Australia, tutoring platform Australia')

@section('left_part')
    {{-- @include('include.left_part') --}}
    @include('include.header_menu_part')
@endsection

@section('content')
@php
$title = 'Message Us';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])
    <section class="contact-form-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-5  mx-auto">
                    <div class="contact-area">
                        @include('include.errors')
                        <h3>Get in touch</h3>
                        <p>Shoot a message and we would be happy to reach out</p>

                        <form id="contactForm" method="post" action="{{ route('send.contact.us') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control required"
                                            placeholder="Your Name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" class="form-control required"
                                            placeholder="Your Email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="number" id="number" class="form-control required"
                                            placeholder="Your Mobile Number" minlength="10" maxlength="10"
                                            onkeypress='validate(event)' autocomplete="off" pattern="\d{10}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div data-column="2" class="form-group">
                                        <select id="role" name="role" class="form-control">
                                            <option value="">Select Role</option>
                                            <option value="parent">Parent / Guardian</option>
                                            <option value="tutor">Tutor</option>
                                            <option value="student">Student</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div data-column="2" class="form-group">
                                        <select id="category" name="category" class="form-control">
                                            <option value="">Select Category </option>
                                            <option value="booking">Booking or Session Support</option>
                                            <option value="tutor">Tutor Onboarding</option>
                                            <option value="payment">Payments or Refunds</option>
                                            <option value="technical">Technical Issue</option>
                                            <option value="inquiry">General Inquiry</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div data-column="2" class="form-group">
                                        <select id="contact_method" name="contact_method" class="form-control">
                                            <option value="">Select Preferred Contact Method </option>
                                            <option value="email">Email</option>
                                            <option value="phone">Phone</option>
                                            <option value="either">Either</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div data-column="2" class="form-group">
                                        <select id="best_time" name="best_time" class="form-control">
                                            <option value="">Select best time to reach you </option>
                                            <option value="morning">Morning</option>
                                            <option value="afternoon">Afternoon</option>
                                            <option value="evening">Evening</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" name="subject" id="subject" class="form-control required"
                                            placeholder="Briefly describe your query or concern.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control message-field required" id="message" cols="30" rows="7"
                                            data-error="Please type your message"
                                            placeholder="Please describe your query or concern in detail so our team can assist you promptly."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn contact-btn disabled"
                                        style="pointer-events: all; cursor: pointer;"> Submit Form </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
    @include('include.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        jQuery.validator.addMethod("emailonly", function(value, element) {
            return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value
                .toLowerCase());
        }, "Enter a valid email address");
        jQuery.validator.addMethod("mobileonly", function(value, element) {
            return this.optional(element) || /^[+]?\d+$/.test(value.toLowerCase());
        }, "Enter a valid 10 digit mobile number");
        $('#contactForm').validate({
            rules: {
                email: {
                    required: true,
                    emailonly: true
                },
                message: {
                    required: true
                },
                subject: {
                    required: true
                },
                name: {
                    required: true
                },
                number: {
                    required: true,
                    mobileonly: true,
                    minlength: 10,
                    maxlength: 10,
                }
            }
        });
    </script>
    <script type="text/javascript">
        $("#contactForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            }
        });
    </script>
    <script type="text/javascript">
        function validate(evt)

        {

            var theEvent = evt || window.event;

            // Handle key press

            var key = theEvent.keyCode || theEvent.which;

            key = String.fromCharCode(key);

            var regex = /[0-9]/;

            if (!regex.test(key)) {

                theEvent.returnValue = false;

                if (theEvent.preventDefault) theEvent.preventDefault();

            }

        }
    </script>
@endsection
