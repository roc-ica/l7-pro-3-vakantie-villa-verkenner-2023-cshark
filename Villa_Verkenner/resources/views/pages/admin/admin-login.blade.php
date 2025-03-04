<x-admin-layout title="Admin">
    <h2>Login to Admin Panel</h2>
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
</x-admin-layout>
