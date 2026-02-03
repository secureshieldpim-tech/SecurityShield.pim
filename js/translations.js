const translations = {
    "es": {
        "nav_inicio": "Inicio",
        "nav_planes": "Planes",
        "nav_contacto": "Contacto",
        "nav_login": "Acceso Lab",

        // SECCIÓN HERO (PRINCIPAL) - Actualizada con la filosofía "Suelo Seguro"
        "hero_title": "Fortaleza Digital Automatizada",
        "hero_text": "Transformamos servidores vulnerables en fortalezas. Aplicamos capas de seguridad en Sistema, Red (UFW), Web (Nginx) y Kernel para blindar tu infraestructura.",
        "hero_btn": "Ver Defensa Activa",

        // CARACTERÍSTICAS (PRINCIPAL.HTML) - Basado en tus capas 2, 3 y 4
        "feat_nmap_title": "Auditoría de Superficie",
        "feat_nmap_text": "Identificamos puertos abiertos y vulnerabilidades visibles antes de aplicar el bastionado.",

        "feat_armor_title": "Hardening Web y Kernel", // Antes era AppArmor
        "feat_armor_text": "Protección Anti-Clickjacking en Nginx, ocultación de versiones y bloqueo de Spoofing a nivel de núcleo.",

        "feat_ssh_title": "Acceso SSH Blindado",
        "feat_ssh_text": "Baneo automático de intrusos (Fail2Ban), banners legales y limitación estricta de intentos de acceso.",

        // SECCIÓN PLANES
        "page_planes_title": "Nuestros Planes",
        "page_planes_subtitle": "Desde el diagnóstico inicial hasta el bastionado integral por capas.",

        "plan_personal_title": "Plan Personal",
        "plan_personal_price": "Gratis",
        "plan_personal_desc": "Diagnóstico de vulnerabilidades.",
        "feat_audit": "Auditoría de Puertos Nmap",
        "feat_report": "Informe de Exposición",
        "feat_no_armor": "Sin Hardening de Kernel",
        "feat_support": "Sin Protección Activa",
        "btn_request": "Solicitar",
        "badge_rec": "RECOMENDADO",

        "plan_business_title": "Plan Empresarial",
        "plan_business_price": "Consultar",
        "plan_business_desc": "Implementación total del Playbook de Seguridad.",

        // CARACTERÍSTICAS DEL PLAN EMPRESARIAL (Basado en tu script Ansible)
        "feat_armor_custom": "Hardening Nginx (Anti-Sniffing)", // Capa 3
        "feat_bastion": "Fail2Ban y Banner Legal SSH", // Capa 1 y 4
        "feat_fw": "Firewall UFW de Mínimo Privilegio", // Capa 2
        "feat_sim": "Actualizaciones Desatendidas", // Capa 1
        "btn_hire": "Contratar Escudo",

        // CONTACTO Y FORMULARIOS (Se mantienen igual, pero revisados)
        "contact_title": "Hablemos de Seguridad",
        "contact_desc": "Estamos ubicados en el IES Pablo Serrano, Zaragoza. Contáctanos para auditorías o implementación de defensas.",
        "role_red": "Red Team / Auditoría Ofensiva",
        "role_blue": "Blue Team / Hardening Ansible", // Pequeño ajuste
        "role_infra": "Infraestructura / Cyber Range",
        "lbl_name": "Nombre",
        "ph_name": "Tu nombre",
        "lbl_email": "Email",
        "lbl_msg": "Mensaje",
        "ph_msg": "¿Cómo podemos ayudarte?",
        "btn_send": "Enviar Mensaje",
        "login_title": "Iniciar Sesión",
        "lbl_user": "Usuario",
        "lbl_pass": "Contraseña",
        "btn_enter": "Entrar al Panel",
        "gw_title": "Confirmar Suscripción",
        "lbl_cardholder": "Titular de la Tarjeta",
        "lbl_cardnumber": "Número de Tarjeta",
        "lbl_expire": "Expira",
        "lbl_cvc": "CVC",
        "btn_pay": "Pagar y Activar",
        "secure_msg": "Transacción cifrada de extremo a extremo.",
        "reg_title": "Crear Cuenta",
        "btn_register": "Registrarse",
        "text_has_account": "¿Ya tienes cuenta?",
        "link_login_action": "Inicia Sesión",
        "ph_email_example": "usuario@ejemplo.com",
        "panel_client_title": "Área de Cliente",
        "btn_logout": "Cerrar Sesión",
        "panel_responses_title": "Respuestas del Equipo",
        "panel_no_msg": "No tienes nuevas respuestas.",
        "table_date": "Fecha",
        "table_subject": "Asunto",
        "table_response": "Respuesta",
        "dash_title": "Panel de Control",
        "dash_msgs_title": "Mensajes Recibidos",
        "dash_no_msg": "No hay mensajes nuevos en el sistema.",
        "table_user": "Usuario",
        "table_msg": "Mensaje",
        "welcome_user": "Bienvenido,",
        "hello_user": "Hola,",
        "text_new_lab": "¿Nuevo en el Lab?",
        "btn_create_account": "Crear Cuenta",
        "footer_text": "© 2026 SecurityShield - Proyecto PIM - Defensa de Servidor Web",
        "footer_source": "Código Fuente",
        "title_login": "Acceso - SecurityShield",
        "title_register": "Crear Cuenta - SecurityShield",
        "title_dashboard": "Dashboard - SecurityShield",
        "title_client": "Área Cliente - SecurityShield",

        // PÁGINA DE BIENVENIDA (INDEX.HTML) - Actualizada
        "welcome_page_title": "SecurityShield - Defensa Linux Avanzada",
        "welcome_line1": "Automatización de seguridad: Actualizaciones desatendidas y Mantenimiento", // Capa 1
        "welcome_line2": "Protección de Red: Firewall UFW y Hardening de Nginx", // Capas 2 y 3
        "welcome_line3": "Defensa profunda: Protección de Kernel y SSH seguro", // Capas 4 y 5
        "welcome_btn": "Empezar",

        "title_profile": "Mi Perfil - SecurityShield",
        "title_config": "Configuración - SecurityShield",
        "menu_profile": "Mi Perfil",
        "menu_config": "Configuración",
        "menu_logout": "Cerrar Sesión",
        "profile_welcome": "Bienvenido a tu área personal",
        "profile_user_id": "Usuario identificado:",
        "profile_status_title": "Estado de Cuenta",
        "profile_status_verified": "Tu cuenta está verificada.",
        "profile_plans_title": "Mis Planes Activos",
        "profile_plans_expire": "Caduca en:",
        "profile_plans_days": "días",
        "profile_no_plans": "No tienes planes activos actualmente.",
        "btn_hire_new_plan": "Contratar nuevo plan →",
        "btn_back_profile": "Volver al Perfil",
        "config_personalization_title": "Personalización",
        "config_personalization_desc": "Elige como quieres ver SecurityShield. Tu preferencia se guardará para futuras sesiones.",
        "theme_default": "Original",
        "theme_light": "Modo Claro",
        "theme_dark": "Modo Oscuro",
        "modal_tech_title": "Configuración del Entorno",
        "modal_tech_desc": "Para prepararte el script de instalación, necesitamos unos datos básicos de tu servidor o máquina.",
        "lbl_client_name": "Nombre (Cliente o Empresa)",
        "lbl_os": "Sistema Operativo",
        "ph_os": "Selecciona tu SO...",
        "lbl_arch": "Arquitectura",
        "ph_arch": "Selecciona arquitectura...",
        "lbl_contact_email": "Email de Contacto (para envío de scripts)",
        "btn_cancel": "Cancelar",
        "btn_confirm_pay": "Confirmar y Pagar",
        "text_no_account": "¿No tienes cuenta?",
        "link_register_action": "Regístrate aquí"
    },
    "en": {
        "nav_inicio": "Home", "nav_planes": "Pricing", "nav_contacto": "Contact", "nav_login": "Lab Access",

        // HERO SECTION
        "hero_title": "Automated Digital Fortress",
        "hero_text": "We transform vulnerable servers into fortresses. We apply security layers at System, Network (UFW), Web (Nginx), and Kernel levels to shield your infrastructure.",
        "hero_btn": "See Active Defense",

        // FEATURES (Main Page)
        "feat_nmap_title": "Surface Audit",
        "feat_nmap_text": "We identify open ports and visible vulnerabilities before applying hardening measures.",

        "feat_armor_title": "Web & Kernel Hardening",
        "feat_armor_text": "Anti-Clickjacking protection in Nginx, version hiding, and Anti-Spoofing blocking at the kernel level.",

        "feat_ssh_title": "Armored SSH Access",
        "feat_ssh_text": "Automatic intruder banning (Fail2Ban), legal banners, and strict access attempt limiting.",

        // PLANS PAGE
        "page_planes_title": "Our Plans",
        "page_planes_subtitle": "From initial diagnostics to comprehensive layered hardening.",

        "plan_personal_title": "Personal Plan",
        "plan_personal_price": "Free",
        "plan_personal_desc": "Vulnerability diagnostics.",
        "feat_audit": "Nmap Port Audit",
        "feat_report": "Exposure Report",
        "feat_no_armor": "No Kernel Hardening",
        "feat_support": "No Active Protection",
        "btn_request": "Request",
        "badge_rec": "RECOMMENDED",

        "plan_business_title": "Business Plan",
        "plan_business_price": "Contact Us",
        "plan_business_desc": "Full Security Playbook implementation.",
        "feat_armor_custom": "Nginx Hardening (Anti-Sniffing)",
        "feat_bastion": "Fail2Ban & SSH Legal Banner",
        "feat_fw": "Least Privilege UFW Firewall",
        "feat_sim": "Unattended Upgrades",
        "btn_hire": "Hire Shield",

        // CONTACT & OTHERS
        "contact_title": "Let's Talk Security",
        "contact_desc": "Located at IES Pablo Serrano, Zaragoza. Contact us for audits or defense implementation.",
        "role_red": "Red Team / Offensive Audit",
        "role_blue": "Blue Team / Ansible Hardening",
        "role_infra": "Infrastructure / Cyber Range",
        "lbl_name": "Name", "ph_name": "Your name", "lbl_email": "Email", "lbl_msg": "Message", "ph_msg": "How can we help you?", "btn_send": "Send Message",
        "login_title": "Login", "lbl_user": "User", "lbl_pass": "Password", "btn_enter": "Enter Panel",
        "gw_title": "Confirm Subscription", "lbl_cardholder": "Card Holder", "lbl_cardnumber": "Card Number", "lbl_expire": "Expires", "lbl_cvc": "CVC", "btn_pay": "Pay & Activate", "secure_msg": "End-to-end encrypted transaction.",
        "reg_title": "Create Account", "btn_register": "Sign Up",
        "text_has_account": "Already have an account?", "link_login_action": "Log In", "ph_email_example": "user@example.com",
        "panel_client_title": "Client Area", "btn_logout": "Logout",
        "panel_responses_title": "Team Responses", "panel_no_msg": "You have no new responses.",
        "table_date": "Date", "table_subject": "Subject", "table_response": "Response",
        "dash_title": "Control Panel", "dash_msgs_title": "Received Messages", "dash_no_msg": "No new messages in the system.",
        "table_user": "User", "table_msg": "Message",
        "welcome_user": "Welcome,", "hello_user": "Hello,",
        "text_new_lab": "New to the Lab?", "btn_create_account": "Create Account",
        "footer_text": "© 2026 SecurityShield - PIM Project - Web Server Defense",
        "footer_source": "Source Code",
        "title_login": "Login - SecurityShield",
        "title_register": "Create Account - SecurityShield",
        "title_dashboard": "Dashboard - SecurityShield",
        "title_client": "Client Area - SecurityShield",

        // WELCOME PAGE (INDEX)
        "welcome_page_title": "SecurityShield - Advanced Linux Defense",
        "welcome_line1": "Security automation: Unattended upgrades and Maintenance",
        "welcome_line2": "Network Protection: UFW Firewall and Nginx Hardening",
        "welcome_line3": "Defense in depth: Kernel protection and Secure SSH",
        "welcome_btn": "Start",

        // PROFILE & CONFIG
        "title_profile": "My Profile - SecurityShield",
        "title_config": "Settings - SecurityShield",
        "menu_profile": "My Profile",
        "menu_config": "Settings",
        "menu_logout": "Logout",
        "profile_welcome": "Welcome to your personal area",
        "profile_user_id": "Identified user:",
        "profile_status_title": "Account Status",
        "profile_status_verified": "Your account is verified.",
        "profile_plans_title": "My Active Plans",
        "profile_plans_expire": "Expires in:",
        "profile_plans_days": "days",
        "profile_no_plans": "You currently have no active plans.",
        "btn_hire_new_plan": "Hire new plan →",
        "btn_back_profile": "Back to Profile",
        "config_personalization_title": "Personalization",
        "config_personalization_desc": "Choose how you want to see SecurityShield. Your preference will be saved for future sessions.",
        "theme_default": "Original",
        "theme_light": "Light Mode",
        "theme_dark": "Dark Mode",
        "modal_tech_title": "Environment Setup",
        "modal_tech_desc": "To prepare the installation script, we need some basic data about your server or machine.",
        "lbl_client_name": "Name (Client or Company)",
        "lbl_os": "Operating System",
        "ph_os": "Select your OS...",
        "lbl_arch": "Architecture",
        "ph_arch": "Select architecture...",
        "lbl_contact_email": "Contact Email (for script delivery)",
        "btn_cancel": "Cancel",
        "btn_confirm_pay": "Confirm and Pay",
        "text_no_account": "Don't have an account?",
        "link_register_action": "Register here"
    },
    "ca": {
        "nav_inicio": "Inici", "nav_planes": "Plans", "nav_contacto": "Contacte", "nav_login": "Accés Lab",

        // HERO
        "hero_title": "Fortalesa Digital Automatitzada",
        "hero_text": "Transformem servidors vulnerables en fortaleses. Apliquem capes de seguretat en Sistema, Xarxa (UFW), Web (Nginx) i Kernel per blindar la teva infraestructura.",
        "hero_btn": "Veure Defensa Activa",

        // FEATURES
        "feat_nmap_title": "Auditoria de Superfície",
        "feat_nmap_text": "Identifiquem ports oberts i vulnerabilitats visibles abans d'aplicar el bastionat.",

        "feat_armor_title": "Hardening Web i Kernel",
        "feat_armor_text": "Protecció Anti-Clickjacking a Nginx, ocultació de versions i bloqueig d'Spoofing a nivell de nucli.",

        "feat_ssh_title": "Accés SSH Blindat",
        "feat_ssh_text": "Baneig automàtic d'intrusos (Fail2Ban), banners legals i limitació estricta d'intents d'accés.",

        // PLANS
        "page_planes_title": "Els Nostres Plans",
        "page_planes_subtitle": "Des del diagnòstic inicial fins al bastionat integral per capes.",
        "plan_personal_title": "Pla Personal", "plan_personal_price": "Gratuït", "plan_personal_desc": "Diagnòstic de vulnerabilitats.",
        "feat_audit": "Auditoria de Ports Nmap",
        "feat_report": "Informe d'Exposició",
        "feat_no_armor": "Sense Hardening de Kernel",
        "feat_support": "Sense Protecció Activa",
        "btn_request": "Sol·licitar",
        "badge_rec": "RECOMANAT",

        "plan_business_title": "Pla Empresarial", "plan_business_price": "Consultar", "plan_business_desc": "Implementació total del Playbook de Seguretat.",
        "feat_armor_custom": "Hardening Nginx (Anti-Sniffing)",
        "feat_bastion": "Fail2Ban i Banner Legal SSH",
        "feat_fw": "Firewall UFW de Mínim Privilegi",
        "feat_sim": "Actualitzacions Desateses",
        "btn_hire": "Contractar Escut",

        // CONTACT
        "contact_title": "Parlem de Seguretat", "contact_desc": "Estem ubicats a l'IES Pablo Serrano, Saragossa. Contacta'ns per a auditories o implementació de defenses.",
        "role_red": "Red Team / Auditoria Ofensiva", "role_blue": "Blue Team / Hardening Ansible", "role_infra": "Infraestructura / Cyber Range",
        "lbl_name": "Nom", "ph_name": "El teu nom", "lbl_email": "Email", "lbl_msg": "Missatge", "ph_msg": "Com et podem ajudar?", "btn_send": "Enviar Missatge",
        "login_title": "Iniciar Sessió", "lbl_user": "Usuari", "lbl_pass": "Contrasenya", "btn_enter": "Entrar al Panell",
        "gw_title": "Confirmar Subscripció", "lbl_cardholder": "Titular de la Targeta", "lbl_cardnumber": "Número de Targeta", "lbl_expire": "Expira", "lbl_cvc": "CVC", "btn_pay": "Pagar i Activar", "secure_msg": "Transacció xifrada d'extrem a extrem.",
        "reg_title": "Crear Compte", "btn_register": "Registrar-se",
        "text_has_account": "Ja tens compte?", "link_login_action": "Inicia Sessió", "ph_email_example": "usuari@exemple.com",
        "panel_client_title": "Àrea de Client", "btn_logout": "Tancar Sessió", "panel_responses_title": "Respostes de l'Equip", "panel_no_msg": "No tens noves respostes.",
        "table_date": "Data", "table_subject": "Assumpte", "table_response": "Resposta",
        "dash_title": "Panell de Control", "dash_msgs_title": "Missatges Rebuts", "dash_no_msg": "No hi ha missatges nous al sistema.",
        "table_user": "Usuari", "table_msg": "Missatge",
        "welcome_user": "Benvingut,", "hello_user": "Hola,",
        "text_new_lab": "Nou al Lab?", "btn_create_account": "Crear Compte",
        "footer_text": "© 2026 SecurityShield - Projecte PIM - Defensa de Servidor Web",
        "footer_source": "Codi Font",
        "title_login": "Accés - SecurityShield",
        "title_register": "Registre - SecurityShield",
        "title_dashboard": "Tauler - SecurityShield",
        "title_client": "Àrea Client - SecurityShield",

        // WELCOME PAGE
        "welcome_page_title": "SecurityShield - Defensa Linux Avançada",
        "welcome_line1": "Automatització de seguretat: Actualitzacions desateses i Manteniment",
        "welcome_line2": "Protecció de Xarxa: Firewall UFW i Hardening de Nginx",
        "welcome_line3": "Defensa profunda: Protecció de Kernel i SSH segur",
        "welcome_btn": "Començar",

        // PROFILE & CONFIG
        "title_profile": "El meu Perfil - SecurityShield",
        "title_config": "Configuració - SecurityShield",
        "menu_profile": "El meu Perfil",
        "menu_config": "Configuració",
        "menu_logout": "Tancar Sessió",
        "profile_welcome": "Benvingut a la teva àrea personal",
        "profile_user_id": "Usuari identificat:",
        "profile_status_title": "Estat del Compte",
        "profile_status_verified": "El teu compte està verificat.",
        "profile_plans_title": "Els meus Plans Actius",
        "profile_plans_expire": "Caduca en:",
        "profile_plans_days": "dies",
        "profile_no_plans": "No tens plans actius actualment.",
        "btn_hire_new_plan": "Contractar nou pla →",
        "btn_back_profile": "Tornar al Perfil",
        "config_personalization_title": "Personalització",
        "config_personalization_desc": "Tria com vols veure SecurityShield. La teva preferència es guardarà per a futures sessions.",
        "theme_default": "Original",
        "theme_light": "Mode Clar",
        "theme_dark": "Mode Fosc",
        "modal_tech_title": "Configuració de l'Entorn",
        "modal_tech_desc": "Per preparar-te l'script d'instal·lació, necessitem unes dades bàsiques del teu servidor o màquina.",
        "lbl_client_name": "Nom (Client o Empresa)",
        "lbl_os": "Sistema Operatiu",
        "ph_os": "Selecciona el teu SO...",
        "lbl_arch": "Arquitectura",
        "ph_arch": "Selecciona arquitectura...",
        "lbl_contact_email": "Email de Contacte (per enviament d'scripts)",
        "btn_cancel": "Cancel·lar",
        "btn_confirm_pay": "Confirmar i Pagar",
        "text_no_account": "No tens compte?",
        "link_register_action": "Registra't aquí"
    },
    "eu": {
        "nav_inicio": "Hasiera", "nav_planes": "Planak", "nav_contacto": "Kontaktua", "nav_login": "Laborategi Sarbidea",

        // HERO
        "hero_title": "Gotorleku Digital Automatizatua",
        "hero_text": "Zerbitzari zaurgarriak gotorleku bihurtzen ditugu. Segurtasun geruzak aplikatzen ditugu Sisteman, Sarean (UFW), Webean (Nginx) eta Kernelean zure azpiegitura blindatzeko.",
        "hero_btn": "Defentsa Aktiboa Ikusi",

        // FEATURES
        "feat_nmap_title": "Azalera-auditoretza",
        "feat_nmap_text": "Ataka irekiak eta zaurgarritasun ikusgarriak identifikatzen ditugu bastionatzea aplikatu aurretik.",

        "feat_armor_title": "Web eta Kernel Hardening-a",
        "feat_armor_text": "Anti-Clickjacking babesa Nginx-en, bertsio ezkutaketa eta Anti-Spoofing blokeoa nukleo mailan.",

        "feat_ssh_title": "SSH Sarbide Blindatua",
        "feat_ssh_text": "Sartzaileen blokeo automatikoa (Fail2Ban), legezko bannerrak eta sarbide saiakeren muga zorrotza.",

        // PLANS
        "page_planes_title": "Gure Planak",
        "page_planes_subtitle": "Hasierako diagnostikotik geruzakako bastionatze integralera.",
        "plan_personal_title": "Plan Pertsonala", "plan_personal_price": "Doan", "plan_personal_desc": "Zaurgarritasun diagnostikoa.",
        "feat_audit": "Nmap Portuen Auditoretza",
        "feat_report": "Esposizio Txostena",
        "feat_no_armor": "Kernel Hardening gabe",
        "feat_support": "Babes Aktiborik Gabe",
        "btn_request": "Eskatu",
        "badge_rec": "GOMENDATUA",

        "plan_business_title": "Enpresa Plana", "plan_business_price": "Kontsultatu", "plan_business_desc": "Segurtasun Playbook-aren inplementazio osoa.",
        "feat_armor_custom": "Nginx Hardening (Anti-Sniffing)",
        "feat_bastion": "Fail2Ban eta SSH Bannerra",
        "feat_fw": "Pribilegio Gutxieneko UFW Firewall-a",
        "feat_sim": "Eguneraketa Desatendituak",
        "btn_hire": "Eskudoa Kontratatu",

        // CONTACT
        "contact_title": "Hitz egin dezagun segurtasunaz", "contact_desc": "IES Pablo Serranon gaude, Zaragozan. Jarri gurekin harremanetan auditoretza edo defentsen inplementaziorako.",
        "role_red": "Red Team / Auditoretza Ofentsiboa", "role_blue": "Blue Team / Ansible Hardening", "role_infra": "Azpiegitura / Cyber Range",
        "lbl_name": "Izena", "ph_name": "Zure izena", "lbl_email": "Posta", "lbl_msg": "Mezua", "ph_msg": "Nola lagun zaitzakegu?", "btn_send": "Mezua Bidali",
        "login_title": "Saioa Hasi", "lbl_user": "Erabiltzailea", "lbl_pass": "Pasahitza", "btn_enter": "Panelean Sartu",
        "gw_title": "Harpidetza Berretsi", "lbl_cardholder": "Txartelaren Jabea", "lbl_cardnumber": "Txartel Zenbakia", "lbl_expire": "Iraungitze", "lbl_cvc": "CVC", "btn_pay": "Ordaindu eta Aktibatu", "secure_msg": "Muturretik muturrera zifratutako transakzioa.",
        "reg_title": "Sortu Kontua", "btn_register": "Erregistratu",
        "text_has_account": "Baduzu konturik?", "link_login_action": "Hasi Saioa", "ph_email_example": "erabiltzailea@adibidea.com",
        "panel_client_title": "Bezeroaren Arloa", "btn_logout": "Saioa Itxi",
        "panel_responses_title": "Taldearen Erantzunak", "panel_no_msg": "Ez duzu erantzun berririk.",
        "table_date": "Data", "table_subject": "Gaia", "table_response": "Erantzuna",
        "dash_title": "Kontrol Panela", "dash_msgs_title": "Jasotako Mezuak", "dash_no_msg": "Ez dago mezu berririk sisteman.",
        "table_user": "Erabiltzailea", "table_msg": "Mezua",
        "welcome_user": "Ongi etorri,", "hello_user": "Kaixo,",
        "text_new_lab": "Berria laborategian?", "btn_create_account": "Sortu Kontua",
        "footer_text": "© 2026 SecurityShield - PIM Proiektua - Web Zerbitzariaren Defentsa",
        "footer_source": "Iturburu Kodea",
        "title_login": "Sarbidea - SecurityShield",
        "title_register": "Erregistroa - SecurityShield",
        "title_dashboard": "Aginte-panela - SecurityShield",
        "title_client": "Bezeroaren Arloa - SecurityShield",

        // WELCOME PAGE
        "welcome_page_title": "SecurityShield - Linux Defentsa Aurreratua",
        "welcome_line1": "Segurtasun automatizazioa: Eguneraketa desatendituak eta Mantentzea",
        "welcome_line2": "Sare Babesa: UFW Firewall-a eta Nginx Hardening-a",
        "welcome_line3": "Defentsa sakona: Kernel babesa eta SSH segurua",
        "welcome_btn": "Hasi",

        // PROFILE & CONFIG
        "title_profile": "Nire Profila - SecurityShield",
        "title_config": "Konfigurazioa - SecurityShield",
        "menu_profile": "Nire Profila",
        "menu_config": "Konfigurazioa",
        "menu_logout": "Saioa Itxi",
        "profile_welcome": "Ongi etorri zure eremu pertsonalera",
        "profile_user_id": "Erabiltzaile identifikatua:",
        "profile_status_title": "Kontuaren Egoera",
        "profile_status_verified": "Zure kontua egiaztatuta dago.",
        "profile_plans_title": "Nire Plan Aktiboak",
        "profile_plans_expire": "Iraungitzen da:",
        "profile_plans_days": "egun",
        "profile_no_plans": "Ez daukazu plan aktiborik une honetan.",
        "btn_hire_new_plan": "Plan berria kontratatu →",
        "btn_back_profile": "Profilera Itzuli",
        "config_personalization_title": "Pertsonalizazioa",
        "config_personalization_desc": "Aukeratu nola ikusi nahi duzun SecurityShield. Zure lehentasuna gordeko da.",
        "theme_default": "Jatorrizkoa",
        "theme_light": "Modu Argia",
        "theme_dark": "Modu Iluna",
        "modal_tech_title": "Ingurunearen Konfigurazioa",
        "modal_tech_desc": "Instalazio script-a prestatzeko, zure zerbitzari edo makinaren oinarrizko datu batzuk behar ditugu.",
        "lbl_client_name": "Izena (Bezeroa edo Enpresa)",
        "lbl_os": "Sistema Eragilea",
        "ph_os": "Hautatu zure SE...",
        "lbl_arch": "Arkitektura",
        "ph_arch": "Hautatu arkitektura...",
        "lbl_contact_email": "Harremanetarako Posta (script-ak bidaltzeko)",
        "btn_cancel": "Utzi",
        "btn_confirm_pay": "Baieztatu eta Ordaindu",
        "text_no_account": "Ez duzu konturik?",
        "link_register_action": "Erregistratu hemen"
    }
};

document.addEventListener('DOMContentLoaded', () => {
    let currentLang = 'es';
    try {
        if (localStorage.getItem('selectedLang')) {
            currentLang = localStorage.getItem('selectedLang');
        }
    } catch (e) { }

    const selector = document.getElementById('language-selector');
    if (selector) {
        selector.value = currentLang;
        selector.addEventListener('change', (e) => {
            const lang = e.target.value;
            try {
                localStorage.setItem('selectedLang', lang);
            } catch (e) { }
            updateLanguage(lang);
        });
    }

    updateLanguage(currentLang);

    function updateLanguage(lang) {
        const elements = document.querySelectorAll('[data-i18n]');

        elements.forEach(element => {
            const key = element.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.placeholder = translations[lang][key];
                } else {
                    element.textContent = translations[lang][key];
                }
            }
        });

        if (translations[lang]) {
            const pageTitleKey = document.querySelector('title')?.getAttribute('data-i18n');
            if (pageTitleKey && translations[lang][pageTitleKey]) {
                document.title = translations[lang][pageTitleKey];
            }
        }
    }
});