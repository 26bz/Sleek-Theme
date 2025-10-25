<?php
/*
 * Sleek Paymenter Theme
 * Copyright (C) 2025 26bz (https://26bz.online/)
 * Licensed under GNU GPLv3 or later. See LICENSE file.
 */

$toggleSettings = [
  [
    'name' => 'direct_checkout',
    'label' => 'Direct Checkout',
    'type' => 'checkbox',
    'default' => false,
    'database_type' => 'boolean',
    'description' => 'Don\'t show the product overview page, go directly to the checkout page',
  ],
  [
    'name' => 'small_images',
    'label' => 'Small Images',
    'type' => 'checkbox',
    'default' => false,
    'database_type' => 'boolean',
    'description' => 'Show small images in the product overview page',
  ],
  [
    'name' => 'show_category_description',
    'label' => 'Show Category Description',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Show the category description in the product overview page/homepage',
  ],
  [
    'name' => 'force_dark_mode',
    'label' => 'Force Dark Mode',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Force dark mode for all users (disables theme toggle)',
  ],
  [
    'name' => 'enable_features_section',
    'label' => 'Enable Features Section',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Show the features section on the homepage',
  ],
  [
    'name' => 'enable_panel_showcase',
    'label' => 'Enable Panel Showcase',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Show the game panel showcase section on the homepage',
  ],
  [
    'name' => 'enable_cta_section',
    'label' => 'Enable CTA Section',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Show the call-to-action section on the homepage',
  ],
  [
    'name' => 'enable_logo_marquee',
    'label' => 'Enable Logo Marquee',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Show the logo marquee section on the homepage',
  ],
];

$heroSettings = [
  [
    'name' => 'home_page_text',
    'label' => 'Hero Title Text',
    'type' => 'markdown',
    'default' => 'Professional **Web Hosting** Made Simple',
    'description' => 'Main headline for the hero section. Use **bold** for emphasis.',
  ],
  [
    'name' => 'hero_description',
    'label' => 'Hero Description Text (Hero only)',
    'type' => 'textarea',
    'default' => 'Reliable, fast, and secure hosting solutions for businesses of all sizes. Get started in minutes with our easy-to-use platform.',
    'description' => 'Paragraph text displayed beneath the hero title. Footer description is managed separately below.',
  ],
  [
    'name' => 'hero_primary_button_text',
    'label' => 'Hero Primary Button Text',
    'type' => 'text',
    'default' => '',
    'description' => 'Text for the primary hero button. Leave empty to hide the button.',
  ],
  [
    'name' => 'hero_primary_button_url',
    'label' => 'Hero Primary Button URL',
    'type' => 'text',
    'default' => '#services',
    'description' => 'URL or anchor for the primary hero button (e.g., #services, /products, https://example.com)',
  ],
  [
    'name' => 'hero_secondary_button_text',
    'label' => 'Hero Secondary Button Text',
    'type' => 'text',
    'default' => '',
    'description' => 'Text for the secondary hero button. Leave empty to hide the button.',
  ],
  [
    'name' => 'hero_secondary_button_url',
    'label' => 'Hero Secondary Button URL',
    'type' => 'text',
    'default' => '/tickets/create',
    'description' => 'URL or route for the secondary hero button (e.g., /contact, /tickets/create)',
  ],
];

$featureDefaults = [
  [
    'index' => 1,
    'ordinal' => 'first',
    'title_default' => 'Lightning Fast',
    'description_default' => 'SSD storage, CDN integration, and optimized servers ensure your website loads in milliseconds.',
    'icon_default' => 'ri-check-line',
  ],
  [
    'index' => 2,
    'ordinal' => 'second',
    'title_default' => 'Bank-Level Security',
    'description_default' => 'Advanced security measures protect your data with SSL certificates, firewalls, and daily backups.',
    'icon_default' => 'ri-shield-keyhole-line',
  ],
  [
    'index' => 3,
    'ordinal' => 'third',
    'title_default' => 'Expert Support 24/7',
    'description_default' => 'Our hosting experts are available around the clock to help with any technical issues or questions.',
    'icon_default' => 'ri-customer-service-2-line',
  ],
  [
    'index' => 4,
    'ordinal' => 'fourth',
    'title_default' => 'Easily Scalable',
    'description_default' => 'Start small and grow big. Upgrade your resources instantly as your business expands.',
    'icon_default' => 'ri-stack-line',
  ],
  [
    'index' => 5,
    'ordinal' => 'fifth',
    'title_default' => 'User-Friendly Control Panel',
    'description_default' => 'Manage your hosting with our intuitive control panel. No technical knowledge required.',
    'icon_default' => 'ri-dashboard-3-line',
  ],
  [
    'index' => 6,
    'ordinal' => 'sixth',
    'title_default' => '99.9% Uptime Guarantee',
    'description_default' => 'Your website stays online with our reliable infrastructure and uptime monitoring.',
    'icon_default' => 'ri-timer-line',
  ],
];

$featureContentSettings = [];
foreach ($featureDefaults as $feature) {
  $featureContentSettings[] = [
    'name' => "feature_{$feature['index']}_title",
    'label' => "Feature {$feature['index']} - Title",
    'type' => 'text',
    'default' => $feature['title_default'],
    'description' => "Title for the {$feature['ordinal']} feature card",
  ];

  $featureContentSettings[] = [
    'name' => "feature_{$feature['index']}_description",
    'label' => "Feature {$feature['index']} - Description",
    'type' => 'textarea',
    'default' => $feature['description_default'],
    'description' => "Description for the {$feature['ordinal']} feature card",
  ];

  $featureContentSettings[] = [
    'name' => "feature_{$feature['index']}_icon",
    'label' => "Feature {$feature['index']} - Icon",
    'type' => 'text',
    'default' => $feature['icon_default'],
    'description' => 'Remix Icon component alias (e.g., ri-check-line). Leave empty to hide the icon.',
  ];
}

$featureSectionSettings = array_merge([
  [
    'name' => 'features_title',
    'label' => 'Features Section Title',
    'type' => 'text',
    'default' => 'Why Choose Our Hosting?',
    'description' => 'Main title for the features section',
  ],
  [
    'name' => 'features_subtitle',
    'label' => 'Features Section Subtitle',
    'type' => 'text',
    'default' => 'We provide everything you need to succeed online with reliable, fast, and secure hosting solutions.',
    'description' => 'Subtitle text for the features section',
  ],
], $featureContentSettings);

$servicesSettings = [
  [
    'name' => 'services_title',
    'label' => 'Services Section Title',
    'type' => 'text',
    'default' => 'Choose Our Hosting Services',
    'description' => 'Main title displayed above the services grid',
  ],
  [
    'name' => 'services_subtitle',
    'label' => 'Services Section Subtitle',
    'type' => 'textarea',
    'default' => 'Explore our range of specialized hosting services designed to meet your specific needs.',
    'description' => 'Supporting text displayed below the services title',
  ],
];

$colorSettings = [
  [
    'name' => 'default_theme',
    'label' => 'Default Theme',
    'type' => 'select',
    'options' => [
      'light' => 'Light',
      'dark' => 'Dark',
    ],
    'default' => 'dark',
    'description' => 'Default theme mode when force dark mode is disabled',
  ],
];

$lightPalette = [
  'primary' => ['label' => 'Primary - Brand Color (Light)', 'default' => 'hsl(0, 0%, 85%)'],
  'secondary' => ['label' => 'Secondary - Brand Color (Light)', 'default' => 'hsl(0, 0%, 65%)'],
  'neutral' => ['label' => 'Borders, Accents... (Light)', 'default' => 'hsl(0, 0%, 30%)'],
  'base' => ['label' => 'Base - Text Color (Light)', 'default' => 'hsl(0, 0%, 0%)'],
  'muted' => ['label' => 'Muted - Text Color (Light)', 'default' => 'hsl(0, 0%, 40%)'],
  'inverted' => ['label' => 'Inverted - Text Color (Light)', 'default' => 'hsl(0, 0%, 100%)'],
  'background' => ['label' => 'Background - Color (Light)', 'default' => 'hsl(0, 0%, 100%)'],
  'background-secondary' => ['label' => 'Background - Secondary Color (Light)', 'default' => 'hsl(0, 0%, 97%)'],
];

foreach ($lightPalette as $name => $data) {
  $colorSettings[] = [
    'name' => $name,
    'label' => $data['label'],
    'type' => 'color',
    'default' => $data['default'],
  ];
}

$darkPalette = [
  'dark-primary' => ['label' => 'Primary - Brand Color (Dark)', 'default' => 'hsl(0, 0%, 85%)'],
  'dark-secondary' => ['label' => 'Secondary - Brand Color (Dark)', 'default' => 'hsl(0, 0%, 65%)'],
  'dark-neutral' => ['label' => 'Borders, Accents... (Dark)', 'default' => 'hsl(0, 0%, 30%)'],
  'dark-base' => ['label' => 'Base - Text Color (Dark)', 'default' => 'hsl(0, 0%, 100%)'],
  'dark-muted' => ['label' => 'Muted - Text Color (Dark)', 'default' => 'hsl(0, 0%, 70%)'],
  'dark-inverted' => ['label' => 'Inverted - Text Color (Dark)', 'default' => 'hsl(0, 0%, 5%)'],
  'dark-background' => ['label' => 'Background - Color (Dark)', 'default' => 'hsl(0, 0%, 5%)'],
  'dark-background-secondary' => ['label' => 'Background - Secondary Color (Dark)', 'default' => 'hsl(0, 0%, 10%)'],
];

foreach ($darkPalette as $name => $data) {
  $colorSettings[] = [
    'name' => $name,
    'label' => $data['label'],
    'type' => 'color',
    'default' => $data['default'],
  ];
}

$panelSettings = [
  [
    'name' => 'panel_showcase_title',
    'label' => 'Panel Showcase Title',
    'type' => 'text',
    'default' => 'Powerful Game Control Panel',
    'description' => 'Title displayed in the panel showcase section',
  ],
  [
    'name' => 'panel_showcase_description',
    'label' => 'Panel Showcase Description',
    'type' => 'textarea',
    'default' => 'Take full control of your game servers with our intuitive control panel. Easily manage settings, monitor performance, and deploy mods with just a few clicks.',
    'description' => 'Description text displayed in the panel showcase section',
  ],
  [
    'name' => 'panel_showcase_image_url',
    'label' => 'Panel Showcase Image URL',
    'type' => 'text',
    'default' => 'https://placehold.co/1200x800',
    'description' => 'URL to the screenshot of the game control panel (recommended size: 1200x800px)',
  ],
];

$logoSettings = [
  [
    'name' => 'logo_marquee_title',
    'label' => 'Logo Marquee Title',
    'type' => 'text',
    'default' => 'Trusted by Community Members',
    'description' => 'Title displayed above the logo marquee',
  ],
  [
    'name' => 'logo_marquee_description',
    'label' => 'Logo Marquee Description',
    'type' => 'textarea',
    'default' => 'Join our growing community of industry professionals who rely on our services.',
    'description' => 'Description text displayed below the marquee title',
  ],
];

$logoImageSettings = [];
for ($i = 1; $i <= 6; $i++) {
  $logoImageSettings[] = [
    'name' => "logo_marquee_image_url_{$i}",
    'label' => "Logo Marquee Image URL {$i}",
    'type' => 'text',
    'default' => sprintf('https://placehold.co/200x80/cccccc/666666?text=Logo+%d', $i),
    'description' => "URL to partner logo {$i} (recommended size: 200x80px)",
  ];
}

$footerSettings = [
  [
    'name' => 'footer_text',
    'label' => 'Footer Description',
    'type' => 'textarea',
    'default' => 'Reliable hosting solutions for businesses of all sizes. Get started in minutes with our easy-to-use platform.',
    'description' => 'Short description text displayed in the footer',
  ],
  [
    'name' => 'footer_cta_text',
    'label' => 'Footer CTA Text',
    'type' => 'text',
    'default' => 'Ready to Get Started?',
    'description' => 'Call to action heading in the footer',
  ],
  [
    'name' => 'footer_cta_description',
    'label' => 'Footer CTA Description',
    'type' => 'textarea',
    'default' => 'Join thousands of satisfied customers who trust us with their hosting needs. Get your website online today!',
    'description' => 'Call to action description text in the footer',
  ],
  [
    'name' => 'cta_primary_text',
    'label' => 'Primary CTA Button Text',
    'type' => 'text',
    'default' => 'Explore Our Services',
    'description' => 'Text for the primary call-to-action button',
  ],
  [
    'name' => 'cta_primary_link',
    'label' => 'Primary CTA Button Link',
    'type' => 'text',
    'default' => '#services',
    'description' => 'Link for the primary call-to-action button (use # for section links or full URLs)',
  ],
  [
    'name' => 'cta_secondary_text',
    'label' => 'Secondary CTA Button Text',
    'type' => 'text',
    'default' => 'Have Questions?',
    'description' => 'Text for the secondary call-to-action button',
  ],
  [
    'name' => 'cta_secondary_link',
    'label' => 'Secondary CTA Button Link',
    'type' => 'text',
    'default' => 'tickets/create',
    'description' => 'Link for the secondary call-to-action button (relative path or full URL)',
  ],
];

$contactSettings = [
  [
    'name' => 'contact_email',
    'label' => 'Contact Email',
    'type' => 'text',
    'default' => '',
    'description' => 'Email address displayed in the footer (leave empty to use system default)',
  ],
  [
    'name' => 'contact_phone',
    'label' => 'Contact Phone',
    'type' => 'text',
    'default' => '',
    'description' => 'Phone number displayed in the footer (leave empty to use system default)',
  ],
  [
    'name' => 'show_theme_attribution',
    'label' => 'Show Theme Attribution',
    'type' => 'checkbox',
    'default' => true,
    'database_type' => 'boolean',
    'description' => 'Display theme attribution in the footer',
  ],
];

$socialSettings = [
  [
    'name' => 'social_twitter',
    'label' => 'Twitter/X URL',
    'type' => 'text',
    'default' => '',
    'description' => 'Twitter/X profile URL (leave empty to hide)',
  ],
  [
    'name' => 'social_facebook',
    'label' => 'Facebook URL',
    'type' => 'text',
    'default' => '',
    'description' => 'Facebook page URL (leave empty to hide)',
  ],
  [
    'name' => 'social_instagram',
    'label' => 'Instagram URL',
    'type' => 'text',
    'default' => '',
    'description' => 'Instagram profile URL (leave empty to hide)',
  ],
  [
    'name' => 'social_discord',
    'label' => 'Discord URL',
    'type' => 'text',
    'default' => '',
    'description' => 'Discord server invite URL (leave empty to hide)',
  ],
];

$settings = array_merge(
  $toggleSettings,
  $heroSettings,
  $featureSectionSettings,
  $servicesSettings,
  $colorSettings,
  $panelSettings,
  $logoSettings,
  $logoImageSettings,
  $footerSettings,
  $contactSettings,
  $socialSettings
);

return [
  'name' => 'sleek',
  'author' => 'contact@26bz.online',
  'url' => 'https://26bz.online/',
  'settings' => $settings,
];
