<x-app-layout>
    <div class="mx-auto max-w-7xl py-24 px-6 lg:px-8">

        @if (session('status'))
            <div class="mb-10">
                <x-document-message-alert>
                    {{ __(session('status')) }}
                </x-document-message-alert>
            </div>
        @endif

        <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-none lg:text-5xl text-center">Privacy Policy</h2>

        <div class="mt-2">
            <div class="*:mb-2">
                <p>This Privacy Policy explains how we collect, use, and disclose your personal information when you visit our website. By using our website, you consent to the terms of this policy.</p>
                <p>1. Information We Collect</p>
                <p>We may collect personal information such as your name, email address, and other contact information when you voluntarily provide it to us through our website.</p>
                <p>2. How We Use Your Information</p>
                <p>We use your personal information to respond to your inquiries, to provide you with information about our products and services, and to improve the content and functionality of our website.</p>
                <p>3. Cookies and Other Tracking Technologies</p>
                <p>We use cookies and other tracking technologies to collect information about your use of our website. This information may include your IP address, browser type, operating system, and other information about your device. We use this information to improve the content and functionality of our website and to personalize your experience.</p>
                <p>4. Sharing Your Information</p>
                <p>We do not sell or share your personal information with third parties except as required by law or as necessary to fulfill your requests.</p>
                <p>5. Security</p>
                <p>We take reasonable measures to protect your personal information from unauthorized access, disclosure, or use.</p>
                <p>6. Copyright Infringements</p>
                <p>If you believe material infringes your copyright, notify us using the contact info below. We'll send a copy to the person responsible. Be aware that false claims may result in liability. Consider consulting an attorney if unsure about infringement.</p>
                <p>7. Children’s Privacy</p>
                <p>Our website is not intended for children under the age of 13. We do not knowingly collect personal information from children under the age of 13.</p>
                <p>8. Changes to this Privacy Policy</p>
                <p>We may update this Privacy Policy from time to time. We will post the updated policy on our website and will indicate the date of the most recent update.</p>
                <p>9. Contact Us</p>
                <p>If you have any questions about this Privacy Policy, please contact us at contact@tunwe.com.</p>
            </div>
        </div>
    </div>
</x-app-layout>
