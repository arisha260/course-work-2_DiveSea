<script setup>

</script>

<template>
  <section class="cookie">
    <div class="container cookie__container">
      <h1 class="main-title cookie__title">Cookie Information</h1>
        <div class="cookie__content">
          <h3 class="main-title cookie__subtitle">Notification of the use of cookies</h3>
          <p class="cookie__text">Our site, like most others, uses cookies and other similar technologies (web beacons, pixel tags, etc.) to provide services that best meet your needs, as well as collect statistical information to analyze and improve our services and sites.
            This Cookie Notice (hereinafter referred to as the "Notice") is part of the Privacy Policy.
            By using this site, you confirm your consent to the use of cookies and other similar technologies in accordance with this Notice.
            If you do not agree to our use of this type of cookies, you must set your browser settings accordingly or not use our site (for more information, see the section "How to manage cookies").</p>
        </div>
        <div class="cookie__content">
          <h3 class="main-title cookie__subtitle">What is a cookie and other similar technologies?</h3>
          <p class="cookie__text">A cookie is a small text file stored on your computer, smartphone or other device that you use to visit the site.
            Some of the visited pages may also collect information using pixel tags and web beacons, which are electronic images called single-pixel (1×1) or blank GIF images.
            Cookies may be placed on your device by us ("own" cookies) or other operators ("third party" cookies).
            We use two types of cookies on the site: "session cookies" and "persistent cookies". Session cookies are temporary files that remain on your device until you leave the site. Persistent cookies remain on your device for a long time or until you manually delete them (how long the cookie will remain on your device will depend on the duration or "lifetime" of a particular file and your browser settings).
            Based on these files, information is collected to help evaluate the effectiveness of our services and sites and improve them. For example, to find out when you visit our site, how you use it, how you interact with email newsletters and other content, remember your preferences, provide a secure and secure service for online transactions, etc.
            The information collected by such files and technologies is generalized in nature and is not related to the identification of individual users.
            However, when you purchase specific products and services from us, we may use the contact information you provided during the transaction in combination with information obtained through cookies and similar technologies to analyze how you use our site and improve it. The processing of such contact data is carried out by us in accordance with the Privacy Policy.</p>
        </div>
        <div class="cookie__content">
          <h3 class="main-title cookie__subtitle">Types of cookies that can be used on our website</h3>
          <p class="cookie__text">Required cookies. These cookies allow you to visit the sites and use their functions. Disabling them will complicate the functioning of the sites and may make their functions and services unavailable.
            Cookies related to performance, efficiency and analytics. These files help us understand how users interact with our site, show problems in its operation (for example, error messages), help us measure the effectiveness of our advertising campaigns and optimize them for users.
            Functional cookies. They help to remember the individual preferences of users and personalize the content of the site for them.
            Advertising cookies. They are used to deliver targeted advertising and help us evaluate the effectiveness of advertising campaigns. We may share these files with the relevant advertising systems and sites where our ads are placed.
            Email. We may also use technologies to track whether you have opened, read, or forwarded certain messages that we have sent to your email. This is necessary to make our communication tools more useful to the user. If you do not want us to receive information about this, you need to cancel your subscription via the Unsubscribe link located at the bottom of the corresponding email newsletter.
            Social media access buttons. They are used so that users can share a link to a page on social networks or make an electronic bookmark. These buttons are links to social networking websites owned by third parties, which, in turn, can record information about your online activity, including on our site. Please read the relevant terms of use and privacy policies of such sites to understand how they use your data and how you can opt out of their use of your data or delete it.
            Third-party web services. Sometimes we use third-party web services on this site. For example, to display certain elements (images, videos, presentations, etc.), organize surveys, pay for products and services through payment systems, etc. As in the case of access buttons to social networks, we cannot prevent these sites or external domains from collecting information about how you use the content of the site.</p>
        </div>
        <div class="cookie__content">
          <h3 class="main-title cookie__subtitle">How do I manage cookies?</h3>
          <p class="cookie__text">Most Internet browsers are initially configured to automatically accept cookies.
            You can change your browser settings in such a way as to block cookies or warn you when they will be sent to your device (refer to the user's guide for a specific browser).
            If you use several devices and/or browsers to access the Internet, the appropriate settings must be changed in each of them.</p>
        </div>
        <div class="cookie__content">
        <div class="cookie__content">
          <h3 class="main-title cookie__subtitle">Changing the terms of use of cookies</h3>
          <p class="cookie__text">We may change this Notice from time to time at our sole discretion.
            Changes to the Notification take effect from the moment the new version is published on the website. The fact that you use our site after making the appropriate changes means that you agree to accept the new version of the Notification.
            The date of the last update and previous editions are indicated at the beginning of this Notice.
            We recommend that you periodically re-read this Notice to familiarize yourself with its current version.</p>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
  .cookie{
    margin: 100px 0;
    &__container{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 50px;
    }
    &__title{
      margin-bottom: 50px;
    }
    &__content{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 20px;
    }
    &__subtitle{
      font-size: 25px;
    }
    &__text{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 16px;
      line-height: 125%;
      color: #000;
    }
  }
</style>