@extends('layouts.app')
@section('title')
<title>V-Tutor | Tutor public profile</title>
@endsection

@section('left_part')
@include('include.header_menu_part')
<link href="{{ public_asset('assets/toastr/build/toastr.min.css') }}" rel="stylesheet">

<style>
    .vt-page {
        --vt-red: #d0021b;
        --vt-red-dark: #b00117;
        --vt-pink: #fdeef0;
        --vt-pink-2: #fbe3e7;
        --vt-border: #f0d4d9;
        --vt-text: #1d1d2b;
        --vt-muted: #6b6b7b;
        --vt-blue-chip: #e3ebff;
        --vt-blue-text: #1c2f8f;
        --vt-green: #12a150;
        background: #fff;
        padding: 50px;
        color: var(--vt-text);
    }

    .vt-page *,
    .vt-page *::before,
    .vt-page *::after {
        box-sizing: border-box;
    }

    #guestRegisterModal {
        z-index: 99999;
    }

    #guestRegisterModal .guest-modal-dialog {
        width: 100%;
        max-width: 470px;
        margin: 30px auto;
    }

    #watchIntroVideo {
        position: relative;
        z-index: 9999;
        pointer-events: auto !important;
        cursor: pointer;
    }

    #guestRegisterModal .guest-modal {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
    }

    /* Header */

    #guestRegisterModal .guest-modal-header {
        position: relative;
        padding: 30px 32px 25px;
        background: linear-gradient(135deg, #fff1f3, #fff);
        border-bottom: 1px solid #f5dfe2;
    }

    #guestRegisterModal .guest-header-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #d0021b;
        color: #fff;
        border-radius: 15px;
        font-size: 23px;
        margin-bottom: 18px;
    }

    #guestRegisterModal .guest-tag {
        display: block;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #d0021b;
        margin-bottom: 8px;
    }

    #guestRegisterModal .guest-modal-header h3 {
        font-size: 25px;
        font-weight: 800;
        color: #20202b;
        margin: 0 0 9px;
    }

    #guestRegisterModal .guest-modal-header p {
        color: #777784;
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
        max-width: 350px;
    }

    #guestRegisterModal .guest-close {
        position: absolute;
        right: 20px;
        top: 18px;
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 50%;
        background: #fff;
        color: #555;
        font-size: 25px;
        line-height: 30px;
        cursor: pointer;
    }

    #guestRegisterModal .guest-close:hover {
        background: #d0021b;
        color: #fff;
    }

    /* Body */

    #guestRegisterModal .guest-modal-body {
        padding: 26px 32px 30px;
    }

    #guestRegisterModal .guest-form-group {
        margin-bottom: 19px;
    }

    #guestRegisterModal .guest-form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #292936;
        margin-bottom: 8px;
    }

    #guestRegisterModal .guest-form-group label span {
        color: #d0021b;
    }


    #guestRegisterModal .guest-input-wrap {
        position: relative;
    }

    #guestRegisterModal .guest-input-wrap>i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #d0021b;
        font-size: 15px;
        z-index: 2;
    }

    #guestRegisterModal .guest-input {
        height: 48px;
        width: 100%;
        border: 1px solid #e6e6ec;
        border-radius: 10px;
        padding: 10px 14px 10px 43px;
        font-size: 14px;
        color: #292936;
        background-color: #fafafd;
        box-shadow: none;
        transition: .2s;
    }

    #guestRegisterModal .guest-input:focus {
        border-color: #d0021b;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(208, 2, 27, .08);
        outline: none;
    }

    #guestRegisterModal .guest-security {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 11px 13px;
        background: #f0faf4;
        border: 1px solid #d7f0e0;
        border-radius: 9px;
        color: #27804b;
        font-size: 12px;
        margin-bottom: 20px;
    }

    #guestRegisterModal .guest-security i {
        font-size: 16px;
    }


    #guestRegisterModal .guest-error {
        font-size: 13px;
    }


    #guestRegisterModal .guest-submit-btn {
        width: 100%;
        height: 51px;
        border: none;
        border-radius: 11px;
        background: #d0021b;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        cursor: pointer;
        transition: .25s;
    }

    #guestRegisterModal .guest-submit-btn:hover {
        background: #ad0016;
        box-shadow: 0 7px 18px rgba(208, 2, 27, .2);
    }

    #guestRegisterModal .guest-submit-btn i {
        transition: transform .2s;
    }

    #guestRegisterModal .guest-submit-btn:hover i {
        transform: translateX(4px);
    }


    @media(max-width: 575px) {

        #guestRegisterModal .guest-modal-dialog {
            margin: 15px;
            width: auto;
        }

        #guestRegisterModal .guest-modal-header {
            padding: 24px 22px 20px;
        }

        #guestRegisterModal .guest-modal-header h3 {
            font-size: 22px;
        }

        #guestRegisterModal .guest-modal-body {
            padding: 22px;
        }

    }

    
    #introVideoModal {
        z-index: 99998;
        background: rgba(24, 6, 10, .55);
        -webkit-backdrop-filter: blur(7px);
        backdrop-filter: blur(7px);
    }

    #introVideoModal .vt-video-dialog {
        max-width: 720px;
        width: calc(100% - 30px);
        margin: 24px auto;
    }

    #introVideoModal.fade .vt-video-dialog {
        transform: translateY(30px) scale(.94);
        opacity: 0;
        transition: transform .35s cubic-bezier(.2, .9, .3, 1.2), opacity .3s ease;
    }

    #introVideoModal.show .vt-video-dialog {
        transform: none;
        opacity: 1;
    }

    #introVideoModal .vt-video-modal {
        position: relative;
        border: none;
        border-radius: 26px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 30px 80px rgba(208, 2, 27, .28), 0 10px 30px rgba(0, 0, 0, .25);
    }

    #introVideoModal .vt-video-modal::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 6px;
        background: linear-gradient(90deg, #d0021b, #ff5a6e, #ef990e, #d0021b);
        background-size: 200% 100%;
        animation: vtVideoGlow 4s linear infinite;
        z-index: 3;
    }

    @keyframes vtVideoGlow {
        0% {
            background-position: 0% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    #introVideoModal .vt-video-close {
        position: absolute;
        right: 14px;
        top: 14px;
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: #fff;
        color: #444;
        font-size: 26px;
        line-height: 36px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .15);
        transition: .25s;
        z-index: 5;
        padding: 0;
    }

    #introVideoModal .vt-video-close:hover {
        background: var(--vt-red, #d0021b);
        color: #fff;
        transform: rotate(90deg);
    }

    #introVideoModal .vt-video-head {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 22px 64px 14px 24px;
        background: linear-gradient(135deg, #fff1f3 0%, #fff 70%);
    }

    #introVideoModal .vt-video-avatar {
        position: relative;
        flex: 0 0 54px;
        width: 54px;
        height: 54px;
    }

    #introVideoModal .vt-video-avatar img {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 16px;
        border: 3px solid #fff;
        box-shadow: 0 5px 14px rgba(208, 2, 27, .25);
        display: block;
    }

    #introVideoModal .vt-video-avatar::after {
        content: "\25B6";
        position: absolute;
        right: -8px;
        bottom: -8px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #d0021b;
        color: #fff;
        font-size: 10px;
        line-height: 26px;
        text-align: center;
        box-shadow: 0 3px 8px rgba(208, 2, 27, .4);
        border: 2px solid #fff;
    }

    #introVideoModal .vt-video-tag {
        display: block;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.6px;
        color: #d0021b;
        margin-bottom: 4px;
    }

    #introVideoModal .vt-video-title h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #20202b;
        line-height: 1.2;
        word-break: break-word;
    }

    #introVideoModal .vt-video-title p {
        display: none;
    }

    #introVideoModal .vt-video-body {
        padding: 4px 24px 6px;
        background: #fff;
    }

    #introVideoModal .vt-video-frame {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 18px;
        background: #12060a;
        box-shadow: 0 0 0 5px #fdeef0, 0 14px 34px rgba(208, 2, 27, .22);
    }

    #introVideoModal .vt-video-frame iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    #introVideoModal .vt-video-loader {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 44px;
        height: 44px;
        margin: -22px 0 0 -22px;
        border: 4px solid rgba(255, 255, 255, .2);
        border-top-color: #ff5a6e;
        border-radius: 50%;
        animation: vtVideoSpin .8s linear infinite;
    }

    @keyframes vtVideoSpin {
        to {
            transform: rotate(360deg);
        }
    }

    #introVideoModal .vt-video-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 14px 24px 22px;
    }

    #introVideoModal .vt-video-foot .vt-video-note {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b6b7b;
        font-weight: 500;
    }

    #introVideoModal .vt-video-foot .vt-video-note i {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #12a150;
        box-shadow: 0 0 0 4px rgba(18, 161, 80, .18);
        display: inline-block;
    }

    #introVideoModal .vt-video-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 0;
        border-radius: 12px;
        background: #d0021b;
        color: #fff !important;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 20px;
        text-decoration: none !important;
        cursor: pointer;
        transition: .25s;
    }

    #introVideoModal .vt-video-cta:hover {
        background: #b00117;
        box-shadow: 0 8px 20px rgba(208, 2, 27, .28);
        transform: translateY(-1px);
    }

    @media (max-width: 575px) {
        #introVideoModal .vt-video-dialog {
            margin: 15px auto;
        }

        #introVideoModal .vt-video-modal {
            border-radius: 20px;
        }

        #introVideoModal .vt-video-head {
            padding: 16px 56px 10px 14px;
            gap: 10px;
        }

        #introVideoModal .vt-video-avatar,
        #introVideoModal .vt-video-avatar img {
            width: 40px;
            height: 40px;
            flex-basis: 40px;
        }

        #introVideoModal .vt-video-title h4 {
            font-size: 16px;
        }

        #introVideoModal .vt-video-body {
            padding: 4px 14px 4px;
        }

        #introVideoModal .vt-video-foot {
            padding: 14px 16px 20px;
            justify-content: center;
            text-align: center;
        }

        #introVideoModal .vt-video-cta {
            width: 100%;
            justify-content: center;
        }
    }

    .vt-page ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .vt-page h1,
    .vt-page h2,
    .vt-page h3,
    .vt-page p {
        color: var(--vt-text);
    }

    .vt-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 16px;
    }

    .vt-ic {
        flex: 0 0 auto;
        vertical-align: middle;
    }

    .vt-gap {
        margin-top: 24px;
    }

    .vt-card {
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: 18px;
        padding: 22px 26px;
        box-shadow: 0 2px 10px rgba(208, 2, 27, .05);
        height: 100%;
        position: relative;
    }

    .vt-exp-slider {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vt-exp-content {
        flex: 1;
        min-width: 0;
    }

    .vt-experience-item {
        display: none;
    }

    .vt-experience-item.active {
        display: list-item;
    }

    #vtExpPrev:disabled,
    #vtExpNext:disabled {
        opacity: .35;
        cursor: not-allowed;
    }

    .vt-program-slider {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vt-program-slider .vt-programs {
        flex: 1;
        min-width: 0;
    }

    .vt-program-item {
        display: none;
    }

    .vt-program-item.active {
        display: block;
    }

    .vt-slider-controls {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 12px;
    }

    .vt-slider-controls .vt-arrow:disabled {
        opacity: .35;
        cursor: not-allowed;
    }

    .vt-slider-controls .vt-arrow {
        flex: 0 0 38px;
    }

    .vt-card.pink {
        background: linear-gradient(135deg, #fff 0%, var(--vt-pink) 100%);
    }

    .vt-card h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 14px;
        line-height: 1.2;
    }

    .vt-card h2 .vt-ic {
        color: var(--vt-red);
    }

    .vt-card.star h2 .vt-ic {
        color: #ef990e;
    }

    .vt-card h3.vt-sub {
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 10px;
    }

    .vt-card-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .vt-card-head h2 {
        margin: 0;
    }

    .vt-all-link {
        color: var(--vt-red) !important;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .vt-all-link:hover {
        text-decoration: underline !important;
    }

    .vt-stars {
        display: inline-flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center;
        gap: 2px;
        white-space: nowrap;
    }

    .vt-stars img {
        display: inline-block !important;
        float: none !important;
        width: 14px;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .vt-stars.sm img {
        width: 16px;
        height: 16px;
    }

    .vt-hero {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        align-items: stretch;
        background: linear-gradient(135deg, #fff 0%, var(--vt-pink) 100%);
        border: 1px solid var(--vt-border);
        border-radius: 22px;
        padding: 26px;
    }

    .vt-avatar {
        position: relative;
        width: 210px;
        flex: 0 0 210px;
    }

    .vt-avatar .vt-photo {
        width: 210px;
        height: 210px;
        object-fit: cover;
        border-radius: 24px;
        display: block;
        border: 6px solid #fff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .12);
    }

    .vt-verified {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 12px;
        background: var(--vt-green);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border-radius: 20px;
        padding: 4px 14px;
        white-space: nowrap;
    }

    .vt-fav {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .2);
        z-index: 2;
        opacity: .9;
    }

    .vt-fav img {
        width: 20px;
        height: 20px;
    }

    .vt-fav.vt-fav-act {
        background: var(--vt-red);
        opacity: 1;
    }

    .vt-fav.vt-fav-act img {
        filter: brightness(0) invert(1);
    }

    .vt-info {
        flex: 1 1 320px;
        border-right: 2px solid var(--vt-border);
        border-left: 2px solid var(--vt-border);
        padding-left: 24px;
        min-width: 0;
    }

    .vt-info h1 {
        font-size: 34px;
        font-weight: 800;
        margin: 0 0 8px;
        word-break: break-word;
    }

    .vt-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .vt-rating .score {
        font-weight: 700;
    }

    .vt-rating .count {
        font-size: 14px;
    }

    .vt-meta {
        font-size: 14px;
        margin-bottom: 18px;
    }

    .vt-meta span+span::before {
        content: "|";
        margin: 0 12px;
        color: #d9c3c7;
    }

    .vt-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .vt-chip-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
    }

    .vt-chip-box .vt-ic {
        color: var(--vt-red);
    }

    .vt-actions {
        background: var(--vt-pink);
        border-radius: 18px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        justify-content: center;
    }

    .vt-actions {
        padding-left: 20px;
        margin-left: 20px;
    }

    .vt-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 10px;
        padding: 13px 16px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none !important;
        cursor: pointer;
        border: 2px solid var(--vt-red);
        transition: .2s;
        text-align: center;
        line-height: 1.2;
    }

    .vt-btn.primary {
        background: var(--vt-red);
        color: #fff !important;
    }

    .vt-btn.primary:hover {
        background: var(--vt-red-dark);
    }

    .vt-btn.outline {
        background: #fff;
        color: var(--vt-red) !important;
    }

    .vt-btn.outline:hover {
        background: var(--vt-pink-2);
    }

    .vt-btn.ghost {
        background: #fff;
        color: #020202 !important;
        border-color: #e3e3ea;
    }

    .vt-btn.ghost:hover {
        background: #f6f6f9;
    }

    .vt-btn.addDisable,
    .vt-btn.pointerEventsNone {
        opacity: .55;
        pointer-events: none;
    }

    .vt-philosophy {
        padding-right: 150px;
        min-height: 190px;
    }

    .vt-corner-img {
        position: absolute;
        right: 14px;
        bottom: 10px;
        width: 130px;
        height: 130px;
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
    }

    .vt-corner-img img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .vt-check li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .vt-check li::before {
        content: "";
        position: absolute;
        left: 2px;
        top: 4px;
        width: 7px;
        height: 12px;
        border: solid var(--vt-green);
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    .vt-check small {
        display: block;
        color: var(--vt-muted);
    }

    .vt-divider {
        border-top: 1px solid var(--vt-border);
        margin: 16px 0;
    }

    .vt-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .vt-pills li {
        background: #fff;
        border: 1px solid #e3e3ea;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 14px;
    }

    .vt-pills.blue li {
        background: var(--vt-blue-chip);
        border-color: var(--vt-blue-chip);
        color: var(--vt-blue-text);
        font-weight: 700;
        padding: 9px 20px;
    }

    .vt-pills.colored li {
        font-weight: 700;
        border-width: 1px;
        border-style: solid;
        padding: 8px 18px;
    }

    .vt-c1 {
        background: #e3ebff !important;
        border-color: #e3ebff !important;
        color: #1c2f8f !important;
    }

    .vt-c2 {
        background: #e0f6ea !important;
        border-color: #e0f6ea !important;
        color: #0e7a3d !important;
    }

    .vt-c3 {
        background: #fff1d6 !important;
        border-color: #fff1d6 !important;
        color: #a35f00 !important;
    }

    .vt-c4 {
        background: #fde3ea !important;
        border-color: #fde3ea !important;
        color: #b0123a !important;
    }

    .vt-c5 {
        background: #efe4ff !important;
        border-color: #efe4ff !important;
        color: #6a2bb8 !important;
    }

    .vt-c6 {
        background: #dcf3f7 !important;
        border-color: #dcf3f7 !important;
        color: #0b6b7c !important;
    }

    .vt-program[class*="vt-c"] strong {
        color: inherit;
    }

    .vt-program[class*="vt-c"] span {
        color: inherit;
        opacity: .8;
    }

    .vt-split {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .vt-split>div {
        flex: 1 1 220px;
    }

    .vt-split>div+div {
        border-left: 1px solid var(--vt-border);
        padding-left: 24px;
    }

    .vt-split h2 {
        margin-bottom: 14px;
    }

    .vt-programs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .vt-program {
        background: var(--vt-pink);
        border-radius: 12px;
        padding: 8px 10px;
        text-align: center;
    }

    .vt-program strong {
        display: block;
        font-size: 15px;
        margin-bottom: 4px;
        line-height: 1.25;
    }

    .vt-program span {
        display: block;
        font-size: 13px;
        color: var(--vt-muted);
    }

    .vt-avail-card {
        height: auto;
    }

    .vt-avail-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .vt-avail-head h2 {
        margin: 0 0 4px;
    }

    .vt-avail-sub {
        margin: 0;
        font-size: 14px;
        color: var(--vt-muted);
    }

    .vt-flex-note {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #e8f7ee;
        border: 1px solid #c6ebd5;
        color: #1b5e3a;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        max-width: 380px;
    }

    .vt-flex-note .vt-ic {
        color: var(--vt-green);
    }

    .vt-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
    }

    .vt-day {
        border: 1px solid #e3e8f5;
        border-radius: 14px;
        overflow: hidden;
        background: #f4f7ff;
    }

    .vt-day-head {
        background: #e3ebff;
        color: var(--vt-blue-text);
        text-align: center;
        font-weight: 800;
        font-size: 17px;
        padding: 10px 6px;
    }

    .vt-day-head.red {
        background: var(--vt-red);
        color: #fff;
    }

    .vt-day-body {
        padding: 12px 8px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .vt-slot {
        display: block;
        text-align: center;
        background: #fde8e4;
        color: #5a3a36;
        border-radius: 20px;
        padding: 7px 6px;
        font-size: 12.5px;
        font-weight: 500;
        line-height: 1.3;
    }

    .vt-slot.na {
        background: #eee;
        color: #888;
    }

    .vt-slider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
    }

    .vt-arrow {
        flex: 0 0 38px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 0;
        background: #f1f1f5;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--vt-text);
    }

    .vt-arrow:hover {
        background: var(--vt-pink-2);
    }

    .vt-slides {
        flex: 1 1 auto;
        min-width: 0;
    }

    .vt-slide {
        display: none;
        align-items: flex-start;
        gap: 16px;
        padding: 10px 0;
    }

    .vt-slide.active {
        display: flex;
    }

    .vt-initials {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: var(--vt-blue-chip);
        color: var(--vt-blue-text);
        font-weight: 800;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 58px;
    }

    .vt-slide .head {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vt-slide .name {
        font-weight: 800;
    }

    .vt-slide p {
        margin: 6px 0 0;
        font-style: italic;
        word-break: break-word;
    }

    .vt-slide small {
        color: var(--vt-muted);
    }

    .vt-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 16px;
    }

    .vt-dots i {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #d8d8e0;
        cursor: pointer;
        display: block;
    }

    .vt-dots i.active {
        background: var(--vt-red);
    }

    .vt-no-reviews {
        text-align: center;
        padding: 24px 10px;
        background: #fafafc;
        border: 1px dashed var(--vt-border);
        border-radius: 14px;
    }

    .vt-no-reviews-ic {
        display: inline-flex;
        color: #cfcfd8;
        margin-bottom: 6px;
    }

    .vt-no-reviews strong {
        display: block;
        font-size: 18px;
        font-weight: 800;
    }

    .vt-no-reviews p {
        margin: 4px 0 0;
        color: var(--vt-muted);
        font-size: 14px;
    }

    .vt-sum {
        color: var(--vt-muted);
        font-size: 14px;
        margin: -6px 0 0;
    }

    .vt-cta {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        background: linear-gradient(135deg, #fff 0%, var(--vt-pink) 100%);
        border: 1px solid var(--vt-border);
        border-radius: 18px;
        padding: 26px 32px;
    }

    .vt-cta .vt-cta-ic {
        color: var(--vt-red);
    }

    .vt-cta .vt-cta-text {
        flex: 1 1 280px;
        border-left: 1px solid var(--vt-border);
        padding-left: 24px;
    }

    .vt-cta h2 {
        font-size: 30px;
        font-weight: 800;
        margin: 0 0 4px;
    }

    .vt-cta p {
        margin: 0;
        color: var(--vt-muted);
    }

    .vt-cta .vt-btn {
        min-width: 270px;
    }
@media (max-width: 575px) {

    #guestRegisterModal {
        padding: 10px !important;
    }

    #guestRegisterModal .guest-modal-dialog {
        width: calc(100% - 20px);
        max-width: 360px;
        margin: 15px auto;
    }

    #guestRegisterModal .guest-modal {
        border-radius: 14px;
    }

    .text-danger{
        font-size: 10px;
        line-height: normal;
    }
    #guestRegisterModal .guest-modal-header {
        padding: 10px 18px 13px;
    }

    #guestRegisterModal .guest-close {
        width: 28px;
        height: 28px;
        right: 12px;
        top: 12px;
        font-size: 21px;
        line-height: 26px;
    }

    #guestRegisterModal .guest-tag {
        font-size: 8px;
        letter-spacing: 1px;
    }

    #guestRegisterModal .guest-modal-header h3 {
        font-size: 19px;
        margin-bottom: 5px;
    }

    #guestRegisterModal .guest-modal-header p {
        font-size: 12px;
        line-height: 1.4;
    }

    #guestRegisterModal .guest-modal-body {
        padding: 15px 18px 18px;
    }

    #guestRegisterModal .guest-form-group {
        margin-bottom: 11px;
    }

    #guestRegisterModal .guest-form-group label {
        font-size: 12px;
        margin-bottom: 5px;
    }

    #guestRegisterModal .guest-input {
        height: 40px;
        font-size: 12px;
        padding: 8px 10px 8px 36px;
    }

    #guestRegisterModal .guest-input-wrap > i {
        left: 12px;
        font-size: 12px;
    }

    #guestRegisterModal .guest-submit-btn {
        height: 43px;
        font-size: 13px;
    }

    #guestRegisterModal .guest-error {
        font-size: 11px;
    }

    #guestRegisterModal .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    #guestRegisterModal .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }
}

/* Very small mobile screens */
@media (max-width: 360px) {

    #guestRegisterModal .guest-modal-dialog {
        max-width: 320px;
    }

    #guestRegisterModal .guest-modal-header {
        padding: 15px 14px 11px;
    }

    #guestRegisterModal .guest-modal-body {
        padding: 12px 14px 15px;
    }

    #guestRegisterModal .guest-modal-header h3 {
        font-size: 17px;
    }

    #guestRegisterModal .guest-modal-header p {
        font-size: 11px;
    }

    #guestRegisterModal .guest-input {
        height: 38px;
    }
}

    @media (max-width: 991px) {
        .vt-info {
            border-left: 0;
            padding-left: 0;
        }

        .vt-actions {
            flex: 1 1 100%;
        }

        .vt-split>div+div {
            border-left: 0;
            padding-left: 0;
        }

        .vt-programs {
            grid-template-columns: repeat(2, 1fr);
        }

        .vt-days {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 575px) {
        .vt-verified{
            bottom:1px;
        }
        .vt-page {
            padding-top: 90px;
        }

        .vt-avatar,
        .vt-avatar .vt-photo {
            width: 160px;
            height: 160px;
            flex-basis: 160px;
        }

        .vt-info h1 {
            font-size: 26px;
        }

        .vt-hero,
        .vt-card,
        .vt-cta {
            padding: 18px;
        }

        .vt-philosophy {
            padding-right: 18px;
            padding-bottom: 150px;
        }

        .vt-cta .vt-cta-text {
            border-left: 0;
            padding-left: 0;
        }

        .vt-cta .vt-btn {
            min-width: 0;
            width: 100%;
        }

        .vt-days {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .vt-split>div.vt-split-years {
        flex: 1.4 1 260px;
    }

    .vt-pills.grid4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }

    .vt-pills.grid4 li {
        padding: 8px 4px;
        text-align: center;
        font-size: 13px;
        white-space: nowrap;
    }

    @media (min-width: 576px) and (max-width: 1199px) {
        .vt-days {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 991px) {
        .vt-page {
            padding: 50px 20px 30px;
        }

        .vt-hero {
            padding: 22px;
            gap: 20px;
        }

        .vt-info {
            border-right: 0;
            flex: 1 1 280px;
        }

        .vt-actions {
            flex: 1 1 100%;
            flex-direction: row;
            flex-wrap: wrap;
            margin-left: 0;
            border-left: 0;
            padding-left: 18px;
        }

        .vt-actions .vt-btn {
            flex: 1 1 200px;
        }

        .vt-split>div.vt-split-years {
            flex: 1 1 260px;
        }

        .vt-cta {
            padding: 22px;
        }

        .vt-cta .vt-cta-text {
            flex: 1 1 240px;
        }
    }

    @media (max-width: 767px) {
        .vt-card h2 {
            font-size: 20px;
        }

        .vt-info h1 {
            font-size: 28px;
        }

        .vt-philosophy {
            padding-right: 26px;
            padding-bottom: 150px;
        }

        .vt-flex-note {
            max-width: 100%;
        }

        .vt-cta h2 {
            font-size: 24px;
        }
    }

    @media (max-width: 575px) {
        .vt-page {
            padding: 90px 12px 24px;
        }

        .vt-wrap {
            padding: 0;
        }

        .vt-hero {
            gap: 16px;
            padding: 16px;
        }

        .vt-avatar {
            margin: 0 auto;
        }

        .vt-info {
            flex-basis: 100%;
            text-align: center;
        }

        .vt-rating,
        .vt-chips {
            justify-content: center;
        }

        .vt-chip-box {
            font-size: 14px;
            padding: 8px 12px;
        }

        .vt-actions {
            padding: 14px;
            flex-direction: column;
        }

        .vt-actions .vt-btn {
            flex: 0 0 auto;
            width: 100%;
        }

        .vt-card h2 {
            font-size: 18px;
        }

        .vt-split>div {
            flex-basis: 100%;
        }

        .vt-split>div+div {
            border-top: 1px solid var(--vt-border);
            padding-top: 16px;
        }

        .vt-pills.grid4 {
            grid-template-columns: repeat(3, 1fr);
        }

        .vt-programs {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .vt-program-slider,
        .vt-exp-slider {
            gap: 4px;
        }

        .vt-arrow {
            flex-basis: 32px;
            width: 32px;
            height: 32px;
        }

        .vt-slider {
            gap: 6px;
        }

        .vt-initials {
            width: 44px;
            height: 44px;
            flex-basis: 44px;
            font-size: 16px;
        }

        .vt-slide {
            gap: 10px;
        }

        .vt-avail-head {
            flex-direction: column;
        }

        .vt-day-head {
            font-size: 15px;
        }

        .vt-cta {
            text-align: center;
            justify-content: center;
        }

        .vt-cta .vt-cta-ic {
            margin: 0 auto;
        }

        .vt-cta h2 {
            font-size: 22px;
        }
    }

    .vt-page {
        padding: 30px 24px;
    }

    .vt-wrap {
        max-width: 1600px;
        padding: 0;
    }

    .vt-hero {
        padding: 22px;
        gap: 20px;
    }

    .vt-avatar {
        width: 185px;
        flex: 0 0 185px;
    }

    .vt-avatar .vt-photo {
        width: 185px;
        height: 185px;
    }

    .vt-info h1 {
        font-size: 30px;
    }

    .vt-chip-box {
        font-size: 14px;
        padding: 8px 14px;
    }

    .vt-btn {
        font-size: 15px;
        padding: 11px 14px;
    }

    .vt-card {
        padding: 18px 22px;
    }

    .vt-card h2 {
        font-size: 20px;
    }

    .vt-card h3.vt-sub {
        font-size: 16px;
    }

    .vt-check li,
    .vt-meta {
        font-size: 14px;
    }

    .vt-cta {
        padding: 22px 28px;
    }

    .vt-cta h2 {
        font-size: 26px;
    }


    @media (max-width: 575px) {

        .vt-info h1 {
            font-size: 26px;
        }

        .vt-avatar,
        .vt-avatar .vt-photo {
            width: 160px;
            height: 160px;
            flex-basis: 160px;
        }

        .vt-hero,
        .vt-card,
        .vt-cta {
            padding: 16px;
        }

        .vt-card h2 {
            font-size: 18px;
        }

        .vt-cta h2 {
            font-size: 22px;
        }
    }

    .vt-card.vt-philosophy {
        padding-right: 170px;
        min-height: 190px;
    }

    .vt-card.vt-philosophy .vt-corner-img {
        right: 20px;
        bottom: 16px;
        width: 130px;
        height: 130px;
    }

    @media (max-width: 767px) {
        .vt-card.vt-philosophy {
            padding-right: 22px;
            padding-bottom: 160px;
            min-height: 0;
        }

        .vt-card.vt-philosophy .vt-corner-img {
            right: 50%;
            transform: translateX(50%);
            bottom: 14px;
        }
    }
</style>
@endsection

@section('content')
@php

$messageUrl = '#';
$allProgramsUrl = '#';
$allReviewsUrl = '#';
$philosophyText = "I focus on building each student's confidence by delivering clear, step-by-step explanations, providing patient and encouraging support, and adapting to their individual learning pace. My goal is to make learning enjoyable, reduce pressure, and help students achieve steady, lasting progress.";
$philosophyImage = null;

$paths = [
'user' => '
<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
<circle cx="12" cy="7" r="4" />',
'pin' => '
<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
<circle cx="12" cy="10" r="3" />',
'cap' => '
<path d="M22 10 12 5 2 10l10 5 10-5z" />
<path d="M6 12v5c3 3 9 3 12 0v-5" />',
'users' => '
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
<circle cx="9" cy="7" r="4" />
<path d="M23 21v-2a4 4 0 0 0-3-3.87" />
<path d="M16 3.13a4 4 0 0 1 0 7.75" />',
'layers' => '
<path d="m12 2 10 5-10 5L2 7l10-5z" />
<path d="m2 17 10 5 10-5" />
<path d="m2 12 10 5 10-5" />',
'calendar' => '
<rect x="3" y="4" width="18" height="18" rx="2" />
<path d="M16 2v4M8 2v4M3 10h18" />',
'star' => '
<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />',
'arrow' => '
<path d="M5 12h14M12 5l7 7-7 7" />',
'left' => '
<path d="m15 18-6-6 6-6" />',
'right' => '
<path d="m9 18 6-6-6-6" />',
'chat' => '
<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />',
'play' => '
<circle cx="12" cy="12" r="10" />
<polygon points="10 8 16 12 10 16 10 8" />',
'leaf' => '
<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z" />
<path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />',
'check' => '
<circle cx="12" cy="12" r="10" />
<path d="m8 12 3 3 5-6" />',
];
$svg = function ($name, $size = 22) use ($paths) {
return '<svg class="vt-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $paths[$name] . '</svg>';
};

$isUser = @Auth::check() && @Auth::user()->user_type == 'U';
$plans = $userDetails->getTutorShipPlan;
$tutorGrades = @$plans->pluck('grade_id')->toArray();
$myGrade = @Auth::user()->grade;
$avg = (float) @$userDetails->avg_review;
$roundedRating = round($avg * 2) / 2;

$gradeNames = $plans->pluck('getGrade')->filter()->unique('id')->sortBy('id')->pluck('grade_name');
$branchNames = $plans->pluck('getBranch')->filter()->unique('id')->sortBy('id')->pluck('branch_name');

$programs = $plans->filter(function ($p) { return $p->getBranch; })
->groupBy(function ($p) { return $p->getBranch->id; })
->map(function ($rows) {
return [
'name' => $rows->first()->getBranch->branch_name,
'grades' => $rows->pluck('getGrade')->filter()->unique('id')->sortBy('id')->pluck('grade_name'),
];
})->sortBy('name');

$fieldsOfStudy = [];
foreach ($userDetails->getTutorAcademic ?? [] as $taqv) {
$fld = $taqv->getFieldStudy->field_of_study ?? null;
if ($fld) { $fieldsOfStudy[] = $fld; }
}
$fieldsOfStudy = array_unique($fieldsOfStudy);

$qualLabels = [
'1' => 'Doctoral Degree', '2' => 'Postgraduate', '3' => "Master's Degree (Research)",
'4' => "Master's Degree", '5' => 'Bachelor Honours Degree', '6' => "Bachelor's Degree",
'7' => 'Associate Degree', '8' => 'Advanced Diploma',
];

$timezone = $userDetails->timezone_id;
$timezoneCity = $timezone
? str_replace('_', ' ', basename(str_replace('\\', '/', $timezone)))
: null;
$stateName = optional($userDetails->getState)->state_name;
$tutorStateId = $userDetails->state_id;
$tutorStateName = $stateName ?? 'registered state';

$stateMap = [
'New South Wales' => 'NSW',
'Victoria' => 'VIC',
'Queensland' => 'QLD',
'South Australia' => 'SA',
'Western Australia' => 'WA',
'Tasmania' => 'TAS',
'Australian Capital Territory' => 'ACT',
'Northern Territory' => 'NT',
];

$stateShort = $stateMap[$stateName] ?? $stateName;

if ($isUser) {
if (@$userDetails->status == 'AA') {
$book = ['modal' => '#notapproved'];
} elseif (@$admin_disable_bookings_values->disable_booking == 'Y' || in_array(date('Y-m-d'), $all_disabled_booking_dates)) {
$book = ['modal' => '#admin_disabled_bookings_popup'];
} elseif (in_array($myGrade, $tutorGrades)) {
$book = ['href' => url('studentbook-class?search_tutor_slug_studentclass=' . @$userDetails->slug . '&search_tutor_id_studentclass=' . @$userDetails->id)];
} else {
$book = ['modal' => '#not_b_popup'];
}
} elseif (!@Auth::check()) {
$book = ['guest' => 'B'];
} else {
$book = ['disabled' => true];
}

$message = @Auth::check() ? ['href' => $messageUrl] : ['guest' => 'M'];

$intro = @$userDetails->video_short_url ? ['modal' => '#introVideoModal'] : ['disabled' => true];

$btn = function ($cfg, $label, $cls, $icon) use ($svg, $userDetails) {
$inner = $svg($icon, 20) . ' <span>' . e($label) . '</span>';
if (isset($cfg['href'])) {
return '<a class="vt-btn ' . $cls . '" href="' . e($cfg['href']) . '">' . $inner . '</a>';
}
if (isset($cfg['modal'])) {
return '<a class="vt-btn ' . $cls . ' open_popup_g" data-toggle="modal" data-target="' . $cfg['modal'] . '" href="javascript:void(0);">' . $inner . '</a>';
}
if (isset($cfg['guest'])) {
return '<a class="vt-btn ' . $cls . ' save_input_data_on_click" data-id="' . $userDetails->id . '" data-toggle="modal" data-target="#log_modal' . $userDetails->id . '" data-type="' . $cfg['guest'] . '" href="javascript:void(0);">' . $inner . '</a>';
}
return '<a class="vt-btn ' . $cls . ' pointerEventsNone addDisable" href="javascript:void(0);">' . $inner . '</a>';
};

$dayNames = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
$slotsByDay = $t_my_av_show->groupBy('day');
$redDays = [2, 4, 6]; // Tue, Thu, Sat get the red header
@endphp

<section class="vt-page gj_tut_pub_pf_sec">
    <div class="vt-wrap">

        <div class="vt-hero">
            <div class="vt-avatar">
                @auth
                <a href="#" class="vt-fav @if(@$userDetails->getuserToFavourite) vt-fav-act @endif saveUsertoFavourite"
                    data-saveUsertoFavourite="{{ @$userDetails->id }}">
                    <img src="{{ public_asset('assets/images/wish.png') }}" alt="favourite">
                </a>
                @endauth
                @if ($userDetails->profile_pic)
                <img class="vt-photo" src="{{ asset('storage/teacher_profile_pic/' . $userDetails->profile_pic) }}" alt="profile_img">
                @else
                <img class="vt-photo selected_avatar_upd" src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img">
                @endif
                @if(@$userDetails->status != 'AA')
                <span class="vt-verified">&#10004; Verified Tutor</span>
                @endif
            </div>

            <div class="vt-info">
                <h1>{{ @$userDetails->f_name . ' ' . @$userDetails->l_name }}</h1>

                <div class="vt-rating">
                    <span class="vt-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($roundedRating>= $i)
                            <img src="{{ public_asset('assets/images/star.png') }}" alt="">
                            @elseif ($roundedRating == $i - 0.5)
                            <img src="{{ public_asset('assets/images/halfstar.png') }}" alt="">
                            @else
                            <img src="{{ public_asset('assets/images/star1.png') }}" alt="">
                            @endif
                            @endfor
                    </span>
                    <span class="score">{{ @$userDetails->avg_review }}</span>
                    <span class="count">({{ @$userDetails->total_no_of_reviews }} reviews)</span>
                </div>

                <div class="vt-meta">
                    @if(!empty($fieldsOfStudy))<span>{{ implode(', ', $fieldsOfStudy) }}</span>@endif
                    @if(@$userDetails->total_experience)<span>{{ $userDetails->total_experience }} of tutoring experience</span>@endif
                </div>

                <div class="vt-chips">
                    @if($timezoneCity || $stateShort)
                    <div class="vt-chip-box">
                        {!! $svg('pin', 20) !!}
                        {{ $timezoneCity }}{{ $timezoneCity && $stateShort ? ', ' : '' }}{{ $stateShort }}
                    </div>
                    @endif
                    @if($branchNames->isNotEmpty())
                    <div class="vt-chip-box">{!! $svg('cap', 20) !!} {{ $branchNames->implode(', ') }}</div>
                    @endif
                    @if($gradeNames->isNotEmpty())
                    <div class="vt-chip-box">{!! $svg('users', 20) !!} {{ $gradeNames->first() }}@if($gradeNames->count() > 1) – {{ $gradeNames->last() }}@endif</div>
                    @endif
                </div>
            </div>

            <!-- Guest Registration Modal -->
            <div class="modal fade" id="guestRegisterModal" tabindex="-1"
                role="dialog" aria-labelledby="guestRegisterModalLabel">

                <div class="modal-dialog modal-dialog-centered guest-modal-dialog"
                    role="document">

                    <div class="modal-content guest-modal">

                        <!-- Header -->
                        <div class="guest-modal-header">


                            <button type="button" class="guest-close"
                                data-dismiss="modal" aria-label="Close">
                                &times;
                            </button>

                            <span class="guest-tag">YOUR LEARNING JOURNEY STARTS HERE</span>

                            <h3 id="guestRegisterModalLabel">
                                Book a Trial Session
                            </h3>

                            <p>
                                Let's find the right learning experience for you.
                                Just share a few details to get started.
                            </p>
                            <div id="state_error" class="text-danger" style="display:none;"></div>

                        </div>

                        <!-- Body -->
                        <div class="modal-body guest-modal-body">

                            <form id="guestRegisterForm">

                                @csrf

                                <input type="hidden" name="tutor_slug"
                                    value="{{ $userDetails->slug }}">

                                <input type="hidden" name="tutor_id"
                                    value="{{ $userDetails->id }}">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="guest-form-group">
                                            <label>First Name <span>*</span></label>
                                            <div class="guest-input-wrap">
                                                <i class="fa fa-user"></i>
                                                <input type="text" name="f_name"
                                                    class="form-control guest-input"
                                                    placeholder="First name"
                                                    minlength="3" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="guest-form-group">
                                            <label>Email Address <span>*</span></label>
                                            <div class="guest-input-wrap">
                                                <i class="fa fa-envelope"></i>
                                                <input type="email" name="email"
                                                    class="form-control guest-input"
                                                    placeholder="Email address"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="guest-form-group">
                                            <label>Year Level <span>*</span></label>
                                            <div class="guest-input-wrap">
                                                <i class="fa fa-graduation-cap"></i>
                                                <select name="grade"
                                                    class="form-control guest-input" required>
                                                    <option value="">Select year level</option>
                                                    @foreach($allGrades as $grade)
                                                    <option value="{{ $grade->id }}">
                                                        {{ $grade->grade_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="guest-form-group">
                                            <label>State <span>*</span></label>
                                            <div class="guest-input-wrap">
                                                <i class="fa fa-map-marker"></i>
                                                <select name="parent_state" id="guest_parent_state"
                                                    class="form-control guest-input" required>

                                                    <option value="">Select state</option>

                                                    @foreach($allStates as $state)
                                                    <option value="{{ $state->id }}"
                                                        data-timezone="{{ $state->time_zone }}">
                                                        {{ $state->state_name }}
                                                    </option>
                                                    @endforeach

                                                </select>

                                                <input type="hidden" name="timezone_id" id="guest_timezone_id">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="guestRegisterError"
                                    class="text-danger guest-error"></div>


                                <button type="submit"
                                    class="guest-submit-btn"
                                    id="guestRegisterSubmit">
                                    <span>Continue to Booking</span>
                                    <i class="fa fa-arrow-right"></i>
                                </button>

                            </form>

                        </div>


                    </div>
                </div>
            </div>

            <div class="vt-actions">
                {!! $btn($message, 'Message Tutor', 'primary', 'chat') !!}

                @if(Auth::check())
                <a href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . $userDetails->slug . '&search_tutor_id_studentclass=' . $userDetails->id) }}"
                    class="vt-btn primary">
                    <i class="fa fa-calendar"></i>
                    <span>Book a Trial Session</span>
                </a>
                @else
                <button type="button"
                    class="vt-btn primary"
                    data-toggle="modal"
                    data-target="#guestRegisterModal">
                    <i class="fa fa-calendar"></i>
                    <span>Book a Trial Session</span>
                </button>
                @endif

                @if(!empty($tutorVideo))
                <button type="button"
                    class="vt-btn ghost js-watch-intro"
                    id="watchIntroVideo"
                    data-video="{{ $tutorVideo }}">
                    {!! $svg('play', 20) !!}
                    <span>Watch Intro Video (1 min)</span>
                </button>
                @else
                <button type="button"
                    class="vt-btn ghost pointerEventsNone addDisable"
                    disabled>
                    {!! $svg('play', 20) !!}
                    <span>Watch Intro Video (1 min)</span>
                </button>
                @endif
            </div>
        </div>

        <div class="row vt-gap">
            <div class="col-lg-6 mb-4">
                <div class="vt-card pink">
                    <h2>{!! $svg('user') !!} About Me</h2>
                    <p class="mb-0">{{ @$userDetails->about_me ?: 'No data' }}</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="vt-card vt-philosophy">
                    <h2>{!! $svg('leaf') !!} My Teaching Philosophy</h2>
                    <p class="mb-0">{{ $philosophyText }}</p>

                    <div class="vt-corner-img">
                        @if($philosophyImage)
                        <img src="{{ $philosophyImage }}" alt="Teaching philosophy">
                        @else
                        <svg viewBox="0 0 120 120" width="120" height="120" aria-hidden="true">
                            <rect x="12" y="92" width="96" height="14" rx="3" fill="#1c9bd8" />
                            <rect x="18" y="78" width="84" height="14" rx="3" fill="#f5a623" />
                            <rect x="24" y="64" width="72" height="14" rx="3" fill="#d0021b" />
                            <path d="M48 64h24l-3 -22H51z" fill="#f4f1ee" stroke="#d9d2cb" />
                            <path d="M60 42C52 30 44 28 38 30c2 8 10 14 22 12z" fill="#2fa84f" />
                            <path d="M60 42c8-16 18-18 26-14-2 10-12 16-26 14z" fill="#12a150" />
                            <path d="M60 42c-2-12 0-22 4-30 6 8 6 20-4 30z" fill="#37b866" />
                        </svg>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="vt-card">
                    <h2>{!! $svg('cap') !!} Qualifications &amp; Experience</h2>

                    <h3 class="vt-sub">Qualifications</h3>
                    @if(count(@$userDetails->getTutorAcademic) > 0)
                    <ul class="vt-check">
                        @foreach(@$userDetails->getTutorAcademic as $val)
                        <li>
                            {{ @$val->getFieldStudy->field_of_study }}
                            ({{ $qualLabels[@$val->qualification] ?? 'Diploma' }})
                            <small>
                                {{ @$val->getUniversity->university_name }}
                                @if(isset($val->effective_date) && $val->effective_date) · {{ date('d-m-Y', strtotime($val->effective_date)) }} @endif
                            </small>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No data</p>
                    @endif

                    <div class="vt-divider"></div>


                    <h3 class="vt-sub">Experience</h3>

                    @if(@$userDetails->total_experience || count(@$userDetails->getTutorExperience) > 0)

                    @if(@$userDetails->total_experience)
                    <p class="mb-2">
                        <strong>{{ $userDetails->total_experience }}</strong> of tutoring experience
                    </p>
                    @endif

                    @if(count(@$userDetails->getTutorExperience) > 0)

                    <div class="vt-exp-slider">

                        <button type="button" class="vt-arrow" id="vtExpPrev" aria-label="Previous experience">
                            {!! $svg('left', 18) !!}
                        </button>

                        <div class="vt-exp-content">
                            <ul class="vt-check mb-0" id="vtExperienceList">

                                @foreach($userDetails->getTutorExperience as $key => $val)

                                <li class="vt-experience-item">
                                    {{ @$val->job_title }} – {{ @$val->organization }}

                                    <small>
                                        {{ @$val->from_year }} - {{ @$val->to_year }}
                                    </small>

                                    @if(@$val->description)
                                    <small>{{ $val->description }}</small>
                                    @endif

                                </li>

                                @endforeach

                            </ul>
                        </div>

                        <button type="button" class="vt-arrow" id="vtExpNext" aria-label="Next experience">
                            {!! $svg('right', 18) !!}
                        </button>

                    </div>
                    @if(count($userDetails->getTutorExperience) > 3)
                    <div class="vt-dots" id="vtExpDots">
                        @for($i = 0; $i < ceil(count($userDetails->getTutorExperience) / 3); $i++)
                            <i class="{{ $i == 0 ? 'active' : '' }}"
                                data-page="{{ $i }}"></i>
                            @endfor
                    </div>
                    @endif
                    @endif

                    @else

                    <p class="text-muted">No data</p>

                    @endif
                </div>
            </div>

            <div class="col-lg-7 mb-4">
                <div class="vt-card mb-4" style="height:auto;">
                    <div class="vt-split">
                        <div>
                            <h2>{!! $svg('layers') !!} Subjects</h2>
                            @if($branchNames->isNotEmpty())
                            <ul class="vt-pills colored">
                                @foreach($branchNames as $branch)
                                <li class="vt-c{{ (($loop->index + 2) % 6) + 1 }}">{{ $branch }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">No data</p>
                            @endif
                        </div>
                        <div class="vt-split-years">
                            <h2>{!! $svg('users') !!} Year Levels</h2>
                            @if($gradeNames->isNotEmpty())
                            <ul class="vt-pills colored grid4">
                                @foreach($gradeNames as $grade)
                                <li class="vt-c{{ ($loop->index % 6) + 1 }}">{{ $grade }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">No data</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="vt-card" style="height:auto;">

                    <div class="vt-card-head">
                        <h2>{!! $svg('layers') !!} Managed Learning Programs</h2>
                    </div>

                    @if(isset($learningPrograms) && $learningPrograms->isNotEmpty())

                    <div class="vt-program-slider">

                        <button type="button" class="vt-arrow" id="vtProgramPrev" aria-label="Previous programs">
                            {!! $svg('left', 18) !!}
                        </button>

                        <div class="vt-programs" id="vtProgramList">
                     @foreach($learningPrograms as $program)

                    <a href="{{ route('program.detail', $program['slug']) }}?{{ http_build_query([
                        'year' => $program['grade_ids']->first(),
                        'state' => \Illuminate\Support\Str::slug($tutorState->state_name ?? '')
                       ]) }}"target="_blank"   rel="noopener noreferrer"
                    class="vt-program vt-program-item vt-c{{ ($loop->index % 6) + 1 }}">

                        <strong>{{ $program['name'] }}</strong>

                        @if($program['grades']->isNotEmpty())
                            <span>{{ $program['grades']->implode(', ') }}</span>
                        @endif

                    </a>

                @endforeach
                        </div>

                        <button type="button" class="vt-arrow" id="vtProgramNext" aria-label="Next programs">
                            {!! $svg('right', 18) !!}
                        </button>

                    </div>
                    @if($learningPrograms->count() > 8)
                    <div class="vt-dots" id="vtProgramDots">
                        @for($i = 0; $i < ceil($learningPrograms->count() / 8); $i++)
                            <i class="{{ $i == 0 ? 'active' : '' }}"
                                data-page="{{ $i }}"></i>
                            @endfor
                    </div>
                    @endif
                    @else

                    <p class="text-muted mb-0">No learning programs available</p>

                    @endif

                </div>
            </div>
        </div>

        <div class="vt-card vt-avail-card mb-4">
            <div class="vt-avail-head">
                <div>
                    <h2>{!! $svg('calendar') !!} Availability</h2>
                    <p class="vt-avail-sub">My weekly availability for online tutoring sessions ({{ $timezoneCity ?: 'local time' }})</p>
                </div>
                <div class="vt-flex-note">
                    {!! $svg('check', 20) !!}
                    <span>Flexible times available - please message me to discuss other options if needed.</span>
                </div>
            </div>

            <div class="vt-days">
                @foreach($dayNames as $num => $label)
                <div class="vt-day">
                    <div class="vt-day-head {{ in_array($num, $redDays) ? 'red' : '' }}">{{ $label }}</div>
                    <div class="vt-day-body">
                        @if(isset($slotsByDay[$num]) && $slotsByDay[$num]->isNotEmpty())
                        @foreach($slotsByDay[$num] as $t)
                        <span class="vt-slot">{{ date('g:i a', strtotime($t->from_time)) }} – {{ date('g:i a', strtotime($t->to_time)) }}</span>
                        @endforeach
                        @else
                        <span class="vt-slot na">Not available</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="vt-card star">
                    <div class="vt-card-head">
                        <h2><span style="color:#ef990e; display:inline-flex;">{!! str_replace('fill="none"', 'fill="currentColor"', $svg('star', 24)) !!}</span> What Parents Say</h2>
                        <a class="vt-all-link" href="{{ $allReviewsUrl }}">View All Reviews {!! $svg('arrow', 16) !!}</a>
                    </div>

                    @if(count($reviews) > 0)
                    <div class="vt-slider">
                        @if(count($reviews) > 1)
                        <button type="button" class="vt-arrow" id="vtPrev" aria-label="Previous review">{!! $svg('left', 18) !!}</button>
                        @endif
                        <div class="vt-slides">
                            @foreach($reviews as $key => $val)
                            <div class="vt-slide {{ $key == 0 ? 'active' : '' }}">
                                <div class="vt-initials">{{ strtoupper(substr(@$val->student->f_name, 0, 1) . substr(@$val->student->l_name, 0, 1)) }}</div>
                                <div>
                                    <div class="head">
                                        <span class="name">{{ @$val->student->f_name }} {{ @$val->student->l_name }}</span>
                                        <span class="vt-stars sm">
                                            @for($i = 0; $i < (int) @$val->ratting; $i++)<img src="{{ public_asset('assets/images/star.png') }}" alt="">@endfor
                                                @for($i = 0; $i < (5 - (int) @$val->ratting); $i++)<img src="{{ public_asset('assets/images/star1.png') }}" alt="">@endfor
                                        </span>
                                    </div>
                                    <p>“{{ @$val->message }}”</p>
                                    <small>{{ date('d/M/y, h:i A', strtotime(@$val->created_at)) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if(count($reviews) > 1)
                        <button type="button" class="vt-arrow" id="vtNext" aria-label="Next review">{!! $svg('right', 18) !!}</button>
                        @endif
                    </div>
                    @if(count($reviews) > 1)
                    <div class="vt-dots vt-review-dots">
                        @foreach($reviews as $key => $val)<i class="{{ $key == 0 ? 'active' : '' }}" data-i="{{ $key }}"></i>@endforeach
                    </div>
                    @endif
                    @else
                    <div class="vt-no-reviews">
                        <span class="vt-no-reviews-ic">{!! $svg('star', 34) !!}</span>
                        <strong>No reviews yet</strong>
                        <p>Reviews from parents will appear here once they are available.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="vt-cta">
            <div class="vt-cta-ic">{!! $svg('layers', 64) !!}</div>
            <div class="vt-cta-text">
                <h2>Ready to get started?</h2>
                <p>Book a trial session with {{ @$userDetails->f_name }} and see how personalised support can make a difference.</p>
            </div>
             @if(Auth::check())
                <a href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . $userDetails->slug . '&search_tutor_id_studentclass=' . $userDetails->id) }}"
                    class="vt-btn primary">
                    <i class="fa fa-calendar"></i>
                    <span>Book a Trial Session</span>
                </a>
                @else
                <button type="button"
                    class="vt-btn primary"
                    data-toggle="modal"
                    data-target="#guestRegisterModal">
                    <i class="fa fa-calendar"></i>
                    <span>Book a Trial Session</span>
                </button>
                @endif
        </div>

    </div>
</section>
@endsection

@section('footer')
<div class="gj_tut_ppf_footer_area">
    @include('include.footer')

    @php
    $simpleModals = [
    'not_b_popup' => 'You cannot book a session outside your grade',
    'notapproved' => 'This V-Tutor is currently unavailable. Please try another tutor',
    'admin_disabled_bookings_popup' => 'You cannot make bookings at this time. Please contact support',
    ];
    @endphp

    @foreach($simpleModals as $id => $msg)
    <div class="modal" id="{{ $id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="meass-popup">
                        <ul>
                            <li>{{ $msg }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if(!empty($tutorVideo))
    <div class="modal fade"
        id="introVideoModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="introVideoModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered vt-video-dialog" role="document">

            <div class="modal-content vt-video-modal">

                <button type="button"
                    class="vt-video-close"
                    data-dismiss="modal"
                    aria-label="Close">&times;</button>

                <div class="vt-video-head">
                    <div class="vt-video-avatar">
                        @if ($userDetails->profile_pic)
                        <img src="{{ asset('storage/teacher_profile_pic/' . $userDetails->profile_pic) }}" alt="{{ @$userDetails->f_name }}">
                        @else
                        <img src="{{ public_asset('assets/images/blank1.png') }}" alt="{{ @$userDetails->f_name }}">
                        @endif
                    </div>
                    <div class="vt-video-title">
                        <span class="vt-video-tag">MEET YOUR TUTOR</span>
                        <h4 id="introVideoModalLabel">{{ @$userDetails->f_name . ' ' . @$userDetails->l_name }}</h4>
                        <p>A quick 1-minute introduction</p>
                    </div>
                </div>

                <div class="vt-video-body">
                    <div class="vt-video-frame">
                        <span class="vt-video-loader"></span>
                        <iframe
                            id="introVideoFrame"
                            src=""
                            title="Tutor intro video"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

            </div>

        </div>

    </div>
    @endif
</div>
@endsection

@section('script')
@include('include.script')
<script src="{{ public_asset('assets/toastr/build/toastr.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).on("click", ".saveUsertoFavourite", function(e) {
        e.preventDefault();
        var obj = $(this);
        var reqData = {
            'jsonrpc': '2.0',
            '_token': '{{ csrf_token() }}',
            'data': {
                'favourite_user_id': obj.attr("data-saveUsertoFavourite")
            }
        };
        $.ajax({
            url: "{{ route('save.user.to.favourite') }}",
            dataType: 'json',
            data: reqData,
            type: 'post',
            success: function(resp) {
                if (resp.result.status == 'Added') {
                    obj.addClass("vt-fav-act");
                } else {
                    obj.removeClass("vt-fav-act");
                }
                toastr.success(resp.result.message);
            },
            error: function() {
                toastr.error("Please refresh the page!");
            }
        });
    });



    $(document).ready(function() {

        $('#guestRegisterModal').on('show.bs.modal', function() {

            $('#guest_tutor_id').val("{{ $userDetails->id }}");

            $('#guest_tutor_slug').val("{{ $userDetails->slug }}");

        });

    });

    $(document).on('click', '#watchIntroVideo', function(e) {

        e.preventDefault();

        var videoUrl = $(this).attr('data-video');

        if (!videoUrl) {
            console.error('Intro video URL not found');
            return;
        }

        videoUrl = videoUrl.trim();

        var match = videoUrl.match(
            /(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/)|youtu\.be\/)([^&?\/]+)/
        );

        if (!match) {
            console.error('Invalid YouTube video URL:', videoUrl);
            return;
        }

        var videoId = match[1];

        var embedUrl = 'https://www.youtube.com/embed/' +
            videoId + '?autoplay=1&rel=0&modestbranding=1';

        $('#introVideoFrame').attr('src', embedUrl);

        $('#introVideoModal').modal('show');

    });

    $('#introVideoModal').on('hidden.bs.modal', function() {

        $('#introVideoFrame').attr('src', '');

    });

    $(document).on('click', '.js-video-book', function() {

        $('#introVideoModal').one('hidden.bs.modal', function() {
            $('#guestRegisterModal').modal('show');
        });

        $('#introVideoModal').modal('hide');

    });


    $(document).ready(function() {

        $('#guestRegisterModal').on('show.bs.modal', function() {

            $('#guest_tutor_id').val("{{ $userDetails->id }}");
            $('#guest_tutor_slug').val("{{ $userDetails->slug }}");

        });

        $('#guest_parent_state').on('change', function() {

            var timezone = $(this).find(':selected').data('timezone') || '';

            $('#guest_timezone_id').val(timezone);

        });
        $('#guestRegisterForm').on('submit', function(e) {

            e.preventDefault();

            var studentStateName = $('#guest_parent_state')
                .find('option:selected')
                .text()
                .trim();

            if (
                !$('#guest_parent_state').val() ||
                studentStateName.toLowerCase() !== tutorStateName.trim().toLowerCase()
            ) {
                $('#guest_parent_state').trigger('change');
                return false;
            }

            var form = $(this);
            var btn = $('#guestRegisterSubmit');

            $('#guestRegisterError').html('');

            var formData = form.serialize();

            formData += '&l_name=N%2FA';

            btn.prop('disabled', true);
            btn.find('span').text('Please wait...');

            $.ajax({

                url: "{{ route('student.guest.register') }}",
                type: "POST",
                data: formData,
                dataType: "json",

                success: function(response) {

                    if (response.success) {

                        $('#guestRegisterModal').modal('hide');

                        let tutorSlug = $('#guestRegisterForm')
                            .find('input[name="tutor_slug"]').val();

                        let tutorId = $('#guestRegisterForm')
                            .find('input[name="tutor_id"]').val();

                        window.location.href =
                            "{{ url('studentbook-class') }}" +
                            "?search_tutor_slug_studentclass=" + encodeURIComponent(tutorSlug) +
                            "&search_tutor_id_studentclass=" + encodeURIComponent(tutorId);

                    } else {

                    }

                },

                error: function(xhr) {

                    var response = xhr.responseJSON;
                    var errorHtml = '';

                    if (response && response.errors) {

                        $.each(response.errors, function(key, value) {
                            errorHtml += '<div>' + value[0] + '</div>';
                        });

                    } else if (response && response.message) {

                        errorHtml = response.message;

                    } else {

                        errorHtml = 'Something went wrong. Please try again.';

                    }

                    $('#guestRegisterError').html(errorHtml);

                },

                complete: function() {

                    btn.prop('disabled', false);
                    btn.find('span').text('Continue to Booking');

                }

            });

        });

    });
    var tutorStateName = @json($tutorStateName);

    $('#guest_parent_state').on('change', function() {

        var studentStateName = $(this).find('option:selected').text().trim();

        var selectedTimezone = $(this).find(':selected').data('timezone');
        $('#guest_timezone_id').val(selectedTimezone);

        var isSameState =
            studentStateName.toLowerCase() === tutorStateName.trim().toLowerCase();

        if (!isSameState) {
         $('#state_error')
    .html(
        'Sorry! This tutor is available only in ' + tutorStateName +
        '. Kindly search tutors matching the State criteria.'
    )
    .show();

            $('#guestRegisterSubmit').prop('disabled', true);
        } else {
            $('#state_error').hide().text('');
            $('#guestRegisterSubmit').prop('disabled', false);
        }
    });

    (function() {
        var slides = $('.vt-slide'),
            dots = $('.vt-review-dots i'),
            cur = 0;
        if (slides.length < 2) {
            return;
        }

        function show(i) {
            cur = (i + slides.length) % slides.length;
            slides.removeClass('active').eq(cur).addClass('active');
            dots.removeClass('active').eq(cur).addClass('active');
        }
        $('#vtPrev').on('click', function() {
            show(cur - 1);
        });
        $('#vtNext').on('click', function() {
            show(cur + 1);
        });
        dots.on('click', function() {
            show(parseInt($(this).data('i'), 10));
        });
    })();

    (function() {

        var items = $('#vtProgramList .vt-program-item');

        var prev = $('#vtProgramPrev');
        var next = $('#vtProgramNext');
        var dotsContainer = $('#vtProgramDots');

        var currentPage = 0;
        var perPage = 8;

        if (!items.length) return;

        function showPrograms(page) {

            var grid = document.getElementById('vtProgramList');

            var columns = window.getComputedStyle(grid)
                .getPropertyValue('grid-template-columns')
                .split(' ').filter(Boolean).length;

            perPage = columns * 2;

            var totalPages = Math.ceil(items.length / perPage);

            currentPage = Math.max(0, Math.min(page, totalPages - 1));

            items.removeClass('active');

            items.slice(
                currentPage * perPage,
                (currentPage + 1) * perPage
            ).addClass('active');

            dotsContainer.empty();

            for (var i = 0; i < totalPages; i++) {

                dotsContainer.append(
                    $('<i>', {
                        'data-page': i,
                        'class': i === currentPage ? 'active' : ''
                    })
                );

            }

            prev.prop('disabled', currentPage === 0);
            next.prop('disabled', currentPage === totalPages - 1);

            prev.toggle(totalPages > 1);
            next.toggle(totalPages > 1);
            dotsContainer.toggle(totalPages > 1);
        }

        prev.on('click', function() {
            showPrograms(currentPage - 1);
        });

        next.on('click', function() {
            showPrograms(currentPage + 1);
        });

        dotsContainer.on('click', 'i', function() {
            showPrograms(parseInt($(this).attr('data-page'), 10));
        });

        showPrograms(0);

        var resizeTimer;

        $(window).on('resize', function() {

            clearTimeout(resizeTimer);

            resizeTimer = setTimeout(function() {
                showPrograms(currentPage);
            }, 150);

        });

    })();

    (function() {

        var items = $('.vt-experience-item');
        var currentPage = 0;
        var perPage = 3;

        var prev = $('#vtExpPrev');
        var next = $('#vtExpNext');
        var dotsContainer = $('#vtExpDots');

        if (!items.length) return;

        var totalPages = Math.ceil(items.length / perPage);

        function showExperience(page) {

            currentPage = Math.max(0, Math.min(page, totalPages - 1));

            items.removeClass('active');

            items.slice(
                currentPage * perPage,
                (currentPage + 1) * perPage
            ).addClass('active');

            dotsContainer.find('i')
                .removeClass('active')
                .eq(currentPage)
                .addClass('active');

            prev.prop('disabled', currentPage === 0);
            next.prop('disabled', currentPage === totalPages - 1);

            prev.toggle(items.length > perPage);
            next.toggle(items.length > perPage);

            dotsContainer.toggle(items.length > perPage);
        }

        prev.on('click', function() {
            showExperience(currentPage - 1);
        });

        next.on('click', function() {
            showExperience(currentPage + 1);
        });

        dotsContainer.on('click', 'i', function() {
            showExperience(parseInt($(this).attr('data-page'), 10));
        });

        showExperience(0);

    })();
</script>
@endsection