<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - FAST System</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#1e40af', /* Blue 800 */
                        secondary: '#f59e0b', /* Amber 500 */
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-1/2 bg-primary"></div>
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gray-100"></div>
        <svg class="absolute top-[40%] left-0 w-full text-gray-100 fill-current" viewBox="0 0 1440 320">
            <path fill-opacity="1" d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,90.7C672,85,768,107,864,133.3C960,160,1056,192,1152,186.7C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center">
            <a href="/" class="flex items-center justify-center gap-2 group">
                <div class="bg-white text-primary p-2 rounded-lg font-bold text-2xl shadow-lg group-hover:scale-105 transition-transform">
                    FAST
                </div>
                <div class="text-white">
                    <span class="block font-bold text-2xl tracking-tight">Future Alumni</span>
                    <span class="block text-xs font-medium text-blue-200 tracking-widest uppercase">& Student Tracker</span>
                </div>
            </a>
        </div>

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
            @yield('content')
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} FAST System. UIN Suska Riau.
        </div>
    </div>

</body>
</html>