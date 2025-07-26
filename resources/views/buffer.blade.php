<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metallic Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ---- Metallic Background Variations ---- */
        .metallic-bg-1 {
            background: radial-gradient(circle at top left,
                    rgba(255, 255, 255, 0.08),
                    rgba(0, 0, 0, 0) 70%),
                linear-gradient(180deg, #0c0a09, #18181b);
        }

        .metallic-bg-2 {
            background: radial-gradient(circle at 30% 20%,
                    rgba(255, 255, 255, 0.05),
                    rgba(0, 0, 0, 0) 60%),
                linear-gradient(135deg, #11100e, #18181b 80%);
        }

        .metallic-bg-3 {
            background: radial-gradient(circle at 70% 30%,
                    rgba(255, 255, 255, 0.04),
                    rgba(0, 0, 0, 0) 60%),
                linear-gradient(180deg, #0c0a09, #131313 90%);
        }

        /* ---- Metallic Card ---- */
        .metallic-card-soft {
            @apply relative rounded-2xl p-5 text-white overflow-hidden;
            background: #11100e;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 0.05),
                0 2px 6px rgba(0, 0, 0, 0.7);
        }

        .metallic-card-soft::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.05) 0%,
                    rgba(255, 255, 255, 0) 40%);
            pointer-events: none;
        }
    </style>
</head>

<body class="metallic-bg-1 min-h-screen text-white">

    <!-- Sidebar -->
    <aside class="w-64 h-screen fixed left-0 top-0 metallic-bg-2 p-5">
        <h1 class="text-xl font-bold mb-8">Dashboard</h1>
        <nav class="space-y-4">
            <a href="#" class="block text-gray-300 hover:text-white">Overview</a>
            <a href="#" class="block text-gray-300 hover:text-white">Users</a>
            <a href="#" class="block text-gray-300 hover:text-white">Reports</a>
            <a href="#" class="block text-gray-300 hover:text-white">Settings</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-10 space-y-8">
        <!-- Dashboard Header -->
        <header>
            <h2 class="text-3xl font-bold">Welcome, Admin</h2>
            <p class="text-gray-400 mt-1">Here's an overview of your data.</p>
        </header>

        <!-- Cards Row -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="metallic-card-soft">
                <h3 class="text-lg font-semibold">Pending Approvals</h3>
                <p class="text-3xl font-bold mt-2">12</p>
            </div>
            <div class="metallic-card-soft">
                <h3 class="text-lg font-semibold">Active Users</h3>
                <p class="text-3xl font-bold mt-2">240</p>
            </div>
            <div class="metallic-card-soft">
                <h3 class="text-lg font-semibold">Events</h3>
                <p class="text-3xl font-bold mt-2">8</p>
            </div>
        </section>

        <!-- Table Section -->
        <section class="metallic-card-soft">
            <h3 class="text-xl font-bold mb-4">Recent Activity</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-600 text-gray-300 text-sm">
                        <th class="py-2 px-4">User</th>
                        <th class="py-2 px-4">Action</th>
                        <th class="py-2 px-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-white/5">
                        <td class="py-2 px-4">John Doe</td>
                        <td class="py-2 px-4">Approved Account</td>
                        <td class="py-2 px-4">July 25, 2025</td>
                    </tr>
                    <tr class="hover:bg-white/5">
                        <td class="py-2 px-4">Jane Smith</td>
                        <td class="py-2 px-4">Updated Profile</td>
                        <td class="py-2 px-4">July 24, 2025</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>