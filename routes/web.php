<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\EventDownloadController;
use App\Http\Controllers\CertificateDownloadController;
use App\Http\Controllers\AttendeeBadgeExportController;
use App\Http\Controllers\AttendeeSingleBadgeExportController;
use App\Http\Controllers\BlankBadgeExportController;
use App\Http\Controllers\PersonnelBadgeExportController;
use App\Http\Controllers\ReportFeedbackExportController;
use App\Http\Controllers\AveryLabelController;
use App\Http\Controllers\AveryPersonnelLabelController;

use App\Livewire\Frontend\RegistrationForm\RegistrationFormController;
use App\Livewire\Frontend\CheckoutSuccess;
use App\Livewire\Frontend\HomeController;
use App\Livewire\Frontend\EventController;
use App\Livewire\Frontend\PrivacyPolicyController;
use App\Livewire\Frontend\CookiesPolicyController;
use App\Livewire\Frontend\AppPrivacyPolicyController;
use App\Livewire\Frontend\AppSupportController;

use App\Livewire\Auth\Login;
use App\Livewire\Actions\Logout;
use App\Livewire\Auth\ForgotPassword;

use App\Http\Middleware\IsCustomer;
use App\Http\Middleware\HasAdminAccess;

use App\Http\Controllers\AttachmentController;

use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SendGridWebhookController;
use App\Http\Controllers\CheckInWebhookController;
use App\Http\Controllers\AppWebhookController;

//admin
Route::middleware(['auth', HasAdminAccess::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::post('/attachments', [AttachmentController::class, 'store'])->name('attachments.store');

        Route::get('/dashboard', \App\Livewire\Backend\Admin\Dashboard::class)->name('dashboard');

        Route::get('/registration-documents/{document}', [AdminDocumentController::class, 'download'])
        ->name('registration-documents.download');


        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Users\Index::class)->name('index');
            Route::get('/create', App\Livewire\Backend\Admin\Users\Create::class)->name('create');
            Route::get('/{user}/edit', App\Livewire\Backend\Admin\Users\Edit::class)->name('edit');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Settings\Index::class)->name('index');
        });

        Route::prefix('developer')->name('developer.')->group(function () {
            Route::prefix('client-settings')->name('client-settings.')->group(function () {
                Route::get('/', App\Livewire\Backend\Admin\Developer\ClientSettings\Index::class)->name('index');
                Route::get('/{category}/manage', App\Livewire\Backend\Admin\Developer\ClientSettings\Manage::class)->name('manage');
            });

            Route::prefix('registration-form')->name('registration-form.')->group(function () {
                Route::get('/', App\Livewire\Backend\Admin\Developer\RegistrationForm\Index::class)->name('index');
            });

            Route::prefix('email-templates')->name('email-templates.')->group(function () {
                Route::get('/', App\Livewire\Backend\Admin\Developer\EmailTemplates\Index::class)->name('index');
            });
        });



        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Events\Index::class)->name('index');
            Route::get('/create', App\Livewire\Backend\Admin\Events\Create::class)->name('create');
            Route::get('/{event}/edit', App\Livewire\Backend\Admin\Events\Edit::class)->name('edit');
            Route::get('/{event}/manage', App\Livewire\Backend\Admin\Events\Manage::class)->name('manage');
        });

        Route::prefix('events/{event}/attendees')->name('events.attendees.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Attendees\Index::class)->name('index');
            Route::get('/badges/export', [AttendeeBadgeExportController::class, 'export'])->name('badges.export');
            Route::get('{attendee}/single-badge/export', [AttendeeSingleBadgeExportController::class, 'export'])->name('single-badge.export');
            Route::get('/blank-badge/export', [BlankBadgeExportController::class, 'export'])->name('blank-badge.export');
            Route::get('{attendee}/label/export', [AveryLabelController::class, 'export'])->name('label.export');
            Route::get('{attendee}/manage', App\Livewire\Backend\Admin\Attendees\Manage::class)->name('manage');
            Route::get('{attendee}/edit', App\Livewire\Backend\Admin\Attendees\Edit::class)->name('edit');
            Route::get('/create', App\Livewire\Backend\Admin\Attendees\Create::class)->name('create');
            Route::get('/groups/create', App\Livewire\Backend\Admin\Attendees\Groups\Create::class)->name('groups.create');
            Route::get('/groups/', App\Livewire\Backend\Admin\Attendees\Groups\Index::class)->name('groups.index');
            Route::get('/groups/{attendee_group}/edit', App\Livewire\Backend\Admin\Attendees\Groups\Edit::class)->name('groups.edit');
            Route::get('/send-email-all', App\Livewire\Backend\Admin\Attendees\SendEmailAll::class)->name('send-email-all');
        });



        Route::prefix('events/{event}/registrations')->name('events.registrations.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Registrations\Index::class)->name('index');
            Route::get('{attendee}/manage', App\Livewire\Backend\Admin\Registrations\Manage::class)->name('manage');
            Route::get('{attendee}/edit', App\Livewire\Backend\Admin\Registrations\Edit::class)->name('edit');
        });

        Route::prefix('events/{event}/content')->name('events.content.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Content\Index::class)->name('index');
            Route::get('{content}/edit', App\Livewire\Backend\Admin\Content\Edit::class)->name('edit');
            Route::get('/create', App\Livewire\Backend\Admin\Content\Create::class)->name('create');
        });

        Route::prefix('events/{event}/emails')->name('events.emails.')->group(function () {
            Route::get('emails/send-email', App\Livewire\Backend\Admin\Emails\SendEmail::class)->name('send-email');
        });

        Route::prefix('events/{event}/downloads')->name('events.downloads.')->group(function () {
            Route::get('{download}/edit', App\Livewire\Backend\Admin\Downloads\Edit::class)->name('edit');
            Route::get('/create', App\Livewire\Backend\Admin\Downloads\Create::class)->name('create');
        });

        Route::prefix('events/{event}/tickets')->name('events.tickets.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Tickets\Index::class)->name('index');
            Route::get('{ticket}/edit', App\Livewire\Backend\Admin\Tickets\Edit::class)->name('edit');
            Route::get('/create', App\Livewire\Backend\Admin\Tickets\Create::class)->name('create');
        });

        Route::prefix('events/{event}/tickets/groups')->name('events.tickets.groups.')->group(function () {
            Route::get('{ticket_group}/edit', App\Livewire\Backend\Admin\Tickets\Groups\Edit::class)->name('edit');
            Route::get('/create', App\Livewire\Backend\Admin\Tickets\Groups\Create::class)->name('create');
        });

        Route::prefix('events/{event}/event-sessions/groups')->name('events.event-sessions.groups.')->group(function () {
            Route::get('/create', App\Livewire\Backend\Admin\EventSessions\Groups\Create::class)->name('create');
            Route::get('/{group}/edit', App\Livewire\Backend\Admin\EventSessions\Groups\Edit::class)->name('edit');
        });

        Route::prefix('events/{event}/event-sessions/types')->name('events.event-sessions.types.')->group(function () {
            Route::get('/create', App\Livewire\Backend\Admin\EventSessions\Types\Create::class)->name('create');
            Route::get('/{type}/edit', App\Livewire\Backend\Admin\EventSessions\Types\Edit::class)->name('edit');
        });

        Route::prefix('events/{event}/event-sessions')->name('events.event-sessions.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\EventSessions\Index::class)->name('index');
            Route::get('/{group}/manage', App\Livewire\Backend\Admin\EventSessions\Manage::class)->name('manage');
            Route::get('/{group}/create', App\Livewire\Backend\Admin\EventSessions\Create::class)->name('create');
            Route::get('/{group}/edit/{event_session}', App\Livewire\Backend\Admin\EventSessions\Edit::class)->name('edit');
        });

        Route::prefix('events/{event}/personnel')->name('events.personnel.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Personnel\Index::class)->name('index');
            Route::get('/badges/export', [PersonnelBadgeExportController::class, 'export'])->name('badges.export');
            Route::get('/create', App\Livewire\Backend\Admin\Personnel\Create::class)->name('create');
            Route::get('/{personnel}/edit', App\Livewire\Backend\Admin\Personnel\Edit::class)->name('edit');
            Route::get('/groups/create', App\Livewire\Backend\Admin\Personnel\Groups\Create::class)->name('groups.create');
            Route::get('/groups/{personnel_group}/edit', App\Livewire\Backend\Admin\Personnel\Groups\Edit::class)->name('groups.edit');
            Route::get('{personnel}/label/export', [AveryPersonnelLabelController::class, 'export'])->name('label.export');
        });

        Route::prefix('events/{event}/emails/')->name('events.emails.broadcasts.')->group(function () {
            Route::get('/', \App\Livewire\Backend\Admin\Emails\Broadcasts\Index::class)
                ->name('index');
        });

        Route::prefix('events/{event}/manual-check-in')->name('events.manual-check-in.')->group(function () {
            Route::get('/', \App\Livewire\Backend\Admin\ManualCheckIn\SelectGroup::class)->name('groups');
            Route::get('/groups/{group}', \App\Livewire\Backend\Admin\ManualCheckIn\SelectSession::class)->name('sessions');
            Route::get('/groups/{group}/sessions/{session}', \App\Livewire\Backend\Admin\ManualCheckIn\GuestList::class)->name('guestlist');
        });

        Route::prefix('events/{event}/reports')->name('events.reports.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\Reports\Index::class)->name('index');
            Route::get('/feedback/{feedback_form}/pdf/export', [ReportFeedbackExportController::class, 'export'])->name('feedback.pdf.export');
            Route::get('/feedback/index', App\Livewire\Backend\Admin\Reports\FeedbackForm\Index::class)->name('feedback.index');
            Route::get('/feedback/{feedback_form}/view', App\Livewire\Backend\Admin\Reports\FeedbackForm\View::class)->name('feedback.view');
            Route::get('/demographics/view', \App\Livewire\Backend\Admin\Reports\Demographics\View::class)
                ->name('demographics.view');
            Route::get('demographics/pdf/export', [\App\Http\Controllers\ReportDemographicsExportController::class, 'export'])
	            ->name('demographics.pdf.export');
            Route::get('/financial/view', \App\Livewire\Backend\Admin\Reports\Financial\View::class)
                ->name('financial.view');
            Route::get('financial/pdf/export', [\App\Http\Controllers\ReportFinancialExportController::class, 'export'])
	            ->name('financial.pdf.export');
            Route::get('payments/export', \App\Http\Controllers\AttendeesPaymentDataExportController::class)
                ->name('payments.export');
            Route::get('/checkin/view', \App\Livewire\Backend\Admin\Reports\Checkin\View::class)
                ->name('checkin.view');
            Route::get('checkin/pdf/export',[\App\Http\Controllers\ReportCheckinExportController::class, 'export'])
                ->name('checkin.pdf.export');
            Route::get('attendees/view', \App\Livewire\Backend\Admin\Reports\Attendees\View::class)
                ->name('attendees.view');
            Route::get('attendees/pdf/export', [\App\Http\Controllers\ReportAttendeeExportController::class, 'export'])
	            ->name('attendees.pdf.export');
            Route::get('attendees/export', \App\Http\Controllers\AttendeesDataExportController::class)
                ->name('attendees.export');
        });

        Route::get('emails/preview/{email_send}', [App\Http\Controllers\EmailPreviewController::class, 'show'])
            ->name('emails.preview');

        Route::prefix('events/{event}/feedback-form')->name('events.feedback-form.')->group(function () {
            Route::get('/', App\Livewire\Backend\Admin\FeedbackForm\Index::class)->name('index');
            Route::get('/{feedback_form}/manage', App\Livewire\Backend\Admin\FeedbackForm\Manage::class)->name('manage');
            Route::get('/{feedback_form}/edit', App\Livewire\Backend\Admin\FeedbackForm\Edit::class)->name('edit');

            Route::prefix('{feedback_form}/groups')->name('groups.')->group(function () {
                Route::get('/create', App\Livewire\Backend\Admin\FeedbackForm\Groups\Create::class)->name('create');
                Route::get('/{group}/edit', App\Livewire\Backend\Admin\FeedbackForm\Groups\Edit::class)->name('edit');
            });

            Route::prefix('{feedback_form}/preview')->name('preview.')->group(function () {
                Route::get('/index', App\Livewire\Backend\Admin\FeedbackForm\Preview\Index::class)->name('index');
            });

            Route::prefix('{feedback_form}/questions')->name('questions.')->group(function () {
                Route::get('{group}/manage', App\Livewire\Backend\Admin\FeedbackForm\Questions\Manage::class)->name('manage');
                Route::get('{group}/create', App\Livewire\Backend\Admin\FeedbackForm\Questions\Create::class)->name('create');
                Route::get('{group}/{question}/edit', App\Livewire\Backend\Admin\FeedbackForm\Questions\Edit::class)->name('edit');
            });

            Route::prefix('{feedback_form}/steps')->name('steps.')->group(function () {
                Route::get('/create', App\Livewire\Backend\Admin\FeedbackForm\Steps\Create::class)->name('create');
                Route::get('/{step}/edit', App\Livewire\Backend\Admin\FeedbackForm\Steps\Edit::class)->name('edit');
            });

            Route::prefix('{feedback_form}/steps')->name('steps.')->group(function () {
                Route::get('/create', App\Livewire\Backend\Admin\FeedbackForm\Steps\Create::class)->name('create');
                Route::get('/{step}/edit', App\Livewire\Backend\Admin\FeedbackForm\Steps\Edit::class)->name('edit');
            });
        });

        Route::get('website/index', App\Livewire\Backend\Admin\Website\Index::class)->name('website.index');
        Route::get('website/testimonials/index', App\Livewire\Backend\Admin\Website\Testimonials\Index::class)->name('website.testimonials.index');
        Route::get('website/testimonials/create', App\Livewire\Backend\Admin\Website\Testimonials\Create::class)->name('website.testimonials.create');
        Route::get('website/testimonials/{testimonial}/edit', App\Livewire\Backend\Admin\Website\Testimonials\Edit::class)->name('website.testimonials.edit');

        Route::get('emails/templates/index', App\Livewire\Backend\Admin\Emails\Templates\Index::class)->name('emails.templates.index');
        Route::get('emails/signatures/index', App\Livewire\Backend\Admin\Emails\Signatures\Index::class)->name('emails.signatures.index');
        Route::get('emails/single-send', App\Livewire\Backend\Admin\Emails\SingleSend::class)->name('emails.send-single');
        Route::get('emails/send-email', App\Livewire\Backend\Admin\Emails\SendEmail::class)->name('emails.send-email');
        Route::get('emails/templates/{email_html_content}/edit', App\Livewire\Backend\Admin\Emails\Templates\Edit::class)->name('emails.templates.edit');
        Route::get('emails/signatures/{signature_html_content}/edit', App\Livewire\Backend\Admin\Emails\Signatures\Edit::class)->name('emails.signatures.edit');
        Route::get('emails/signatures/create', App\Livewire\Backend\Admin\Emails\Signatures\Create::class)->name('emails.signatures.create');

        Route::get('emails/broadcasts/index', App\Livewire\Backend\Admin\Emails\Broadcasts\Index::class)->name('emails.broadcasts.index');
        Route::get('{event}/emails/broadcasts/{broadcast}', App\Livewire\Backend\Admin\Emails\Broadcasts\Show::class)->name('emails.broadcasts.show');
        Route::get('{event}/emails/broadcasts/{email_send}/view', App\Livewire\Backend\Admin\Emails\Broadcasts\View::class)->name('emails.broadcasts.view');

        Route::prefix('app')->name('app.')->group(function () {
            Route::get('/index', App\Livewire\Backend\Admin\App\Index::class)->name('index');
        });
    });

//Customer admin
Route::middleware(['auth', IsCustomer::class])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', \App\Livewire\Backend\Customer\Dashboard::class)->name('dashboard');

        Route::get('profile/{user}/edit', \App\Livewire\Backend\Customer\Profile\Edit::class)->name('profile.edit');
        Route::get('profile/{user}/marketing/edit', \App\Livewire\Backend\Customer\Profile\Marketing\Edit::class)->name('profile.marketing.edit');

        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/{user}', App\Livewire\Backend\Customer\Bookings\Index::class)->name('index');
            Route::get('/{event}/attendees/{attendee}/single-badge/export', [AttendeeSingleBadgeExportController::class, 'export'])
                ->name('single-badge.export');
            Route::get('/{user}/edit/{registration}', App\Livewire\Backend\Customer\Bookings\Edit::class)->name('edit');
            Route::get('/{user}/manage/{registration}', App\Livewire\Backend\Customer\Bookings\Manage::class)->name('manage');
        });

        Route::prefix('feedback')->name('feedback.')->group(function () {
            Route::get('{event}/form/{feedback_form}', App\Livewire\Backend\Customer\Feedback\Form::class)->name('form');
            Route::get('{event}/form/{feedback_form}/complete', App\Livewire\Backend\Customer\Feedback\Form::class)->name('complete');
        });

        Route::get('/event-completed-certificate/{booking}', [CertificateDownloadController::class, 'download'])->name('event-completed-certificate.download');
        
    });


//Guest 
Route::middleware('guest')->group(function () {

    Route::get('/app-review', App\Livewire\Backend\Admin\AppReview\Index::class)->name('index');
    
    Route::get('/login', Login::class)->name('login');
    Route::get('/forgotten-password', ForgotPassword::class)->name('forgotten-password');
});

Route::get('/logout', Logout::class)->name('logout');

//Front end
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('privacy-policy');
Route::get('/cookies-policy', [CookiesPolicyController::class, 'show'])->name('cookies-policy');
Route::get('/check-in-app/privacy-policy', [AppPrivacyPolicyController::class, 'show'])->name('check-in-app-privacy-policy');
Route::get('/check-in-app/support', [AppSupportController::class, 'show'])->name('check-in-app-support');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event');
Route::get('/event/download/{id}', [EventDownloadController::class, 'download'])
    ->name('event.download');
Route::get('/registration/{event}', RegistrationFormController::class)->name('registration');
Route::get('/checkout/success/{registration_id}/{event}', CheckoutSuccess::class)->name('checkout.success');

//Webhook
Route::post('/webhooks/stripe', StripeWebhookController::class);
Route::post('/webhooks/sendgrid/' . config('api.webhook_uuid'), SendGridWebhookController::class);
Route::post('/webhooks/checkin/', CheckInWebhookController::class)->middleware('throttle:300,1');

Route::prefix('/webhooks/app/')->group(function () {
    Route::post('/login/', [AppWebhookController::class, 'login'])->middleware('throttle:60,1');
    Route::post('/events/', [AppWebhookController::class, 'events'])->middleware('throttle:60,1');
    Route::post('/sessionGroups/', [AppWebhookController::class, 'sessionGroups'])->middleware('throttle:60,1');
    Route::post('/sessions/', [AppWebhookController::class, 'sessions'])->middleware('throttle:60,1');
    Route::post('/attendees/', [AppWebhookController::class, 'attendees'])->middleware('throttle:60,1');
    Route::post('/checkin/', [AppWebhookController::class, 'checkin'])->middleware('throttle:60,1');
});

Route::get('/webhooks/stripe', function () {
    abort(404);
});

Route::get('/webhooks/sendgrid/' . config('api.webhook_uuid'), function () {
    abort(404);
});

Route::get('/webhooks/checkin/', function () {
    abort(404);
});

require __DIR__.'/auth.php';
