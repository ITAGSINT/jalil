@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/yes.css') }}" rel="stylesheet">
@endsection
@section('content')


<div class="container">
  <div class="row w-100">
   
    <div class="col-lg-12 col-md-12" style="background-color: white; border-radius:2.25rem;padding: 1.5rem;">
      <div class="row w-100 pt-4">
        <div class="col-12">
        <div class="row w-100 d-grid align-items-start choosesize">
            <div class="col-12">
              <p>Terms and Conditions</p>


            </div>   </div>
        <p>Terms and Conditions for Abduljalil Chhada Autospare Parts Trading LLC Application
        Introduction
        Welcome to the Abduljalil Chhada Autospare Parts Trading LLC application. By downloading, installing, or using this application, you agree to comply with and be bound by the following terms and conditions. Please review these terms carefully. If you do not agree with these terms, you should not use this application.
        User Accounts
        - **Registration**: To use certain features of the application, you must create an account. You agree to provide accurate and complete information during registration.
        - **Account Security**: You are responsible for maintaining the confidentiality of your account information, including your password. You agree to notify us immediately of any unauthorized use of your account.
        - **Eligibility**: You must be at least 18 years old to use this application. By using the application, you represent that you meet this age requirement.
        Services
        The application provides the following services:
        - Car wash
        - Car battery inspection
        - Jump start
        - Oil change
        Data Collection and Privacy
        - **Data Collected**: We collect personal data such as name, address, phone number, car information, and payment information (processed through Stripe).
        - **Data Usage**: The data collected is used for installation and delivery services, as well as customer support.
        - **Data Protection**: We comply with the UAE Federal Decree-Law No. 45 of 2021 on the Protection of Personal Data (PDPL). For more details, please refer to our [Data Protection Agreement](#).
        Payment
        - **Payment Processing**: Payments are processed through Stripe. We do not store or handle payment information directly.
        - **Refunds**: Refunds will be handled according to our refund policy. Please contact our customer support for more details.
        User Responsibilities
        - **Accurate Information**: You agree to provide accurate and complete information when using the application.
        - **Compliance with Laws**: You agree to comply with all applicable laws and regulations when using the application.
        - **Prohibited Activities**: You agree not to engage in any activities that are unlawful, harmful, or disruptive to the application or other users.
        Intellectual Property
        - **Ownership**: All content, features, and functionality of the application are owned by Abduljalil Chhada Autospare Parts Trading LLC and are protected by international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.
        - **Usage Rights**: You are granted a limited, non-exclusive, non-transferable, and revocable license to use the application for personal, non-commercial use only.
        Limitation of Liability
        - **No Warranty**: The application is provided 'as is' and 'as available' without any warranties of any kind, either express or implied.
        - **Limitation**: To the fullest extent permitted by applicable law, Abduljalil Chhada Autospare Parts Trading LLC shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues.
        Termination
        - **Termination by User**: You may terminate your account at any time by deleting the application or contacting customer support.
        - **Termination by Us**: We may terminate or suspend your account or access to the application at any time, without prior notice or liability, for any reason, including if you breach these terms.
        Changes to Terms
        We reserve the right to modify these terms at any time. Any changes will be communicated through a pop-up notification on the application after the welcoming page and via email. Your continued use of the application after any changes indicates your acceptance of the new terms.
        Governing Law
        These terms are governed by and construed in accordance with the laws of the United Arab Emirates.
        Contact Information
        For any questions or concerns about these terms, please contact us at:
        - **Email**: contact@tlbni.com
        - **Phone**: 00971542899793
        - **Address**: UAE, Dubai, Naif, Al-Qouzi Building, Shop 32
        </p>
        </div>
        {{-- <div class="col-1">
                <a href="{{route('website.add',1)}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
        <i class="bi bi-plus" style="color: #9098A5; "></i>

        </i>
        </a>
      </div>--}}
        </div>


   
    </div>

</div>
@endsection
@section('additional_scripts')