@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            <h1>Dashboard Overview</h1>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div class="card glass">
                    <h3 style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Manage Products</h3>
                    <p style="font-size: 1.25rem; font-weight: 600; margin: 0.5rem 0;">Keep inventory up to date</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary"
                        style="padding: 0.5rem 1rem; font-size: 0.875rem;">View Inventory</a>
                </div>
                <div class="card glass">
                    <h3 style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Quick Action</h3>
                    <p style="font-size: 1.25rem; font-weight: 600; margin: 0.5rem 0;">Add new product</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"
                        style="padding: 0.5rem 1rem; font-size: 0.875rem;">Create New</a>
                </div>
            </div>

            <div class="card glass">
                <h2>Bulk Product Import</h2>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Upload a CSV or Excel file to import products in
                    bulk. Up to 100k items supported via background processing.</p>
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; gap: 1rem; align-items: flex-end;">
                        <div class="input-group" style="margin-bottom: 0; flex-grow: 1;">
                            <input type="file" name="file" required style="padding: 0.6rem;">
                        </div>
                        <button type="submit" class="btn btn-primary">Start Import</button>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <h1>Users Presence</h1>
            <div class="card glass" style="min-height: 400px;">
                <div id="presence-list">
                    <ul style="list-style: none;">
                        <li id="no-users" style="color: var(--text-muted);">Checking online users...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const presenceList = document.querySelector('#presence-list ul');

        window.Echo.join('online')
            .here((users) => {
                presenceList.innerHTML = '';
                if (users.length === 0) {
                    presenceList.innerHTML = '<li style="color: var(--text-muted);">No one is online</li>';
                }
                users.forEach(user => {
                    addUserToList(user);
                });
            })
            .joining((user) => {
                addUserToList(user);
            })
            .leaving((user) => {
                const item = document.getElementById(`user-${user.id}-${user.type}`);
                if (item) item.remove();
                if (presenceList.children.length === 0) {
                    presenceList.innerHTML = '<li style="color: var(--text-muted);">No one is online</li>';
                }
            })
            .error((error) => {
                console.error('Presence Channel Error:', error);
            });

        function addUserToList(user) {
            const id = `user-${user.id}-${user.type}`;
            if (!document.getElementById(id)) {
                const noUsers = document.getElementById('no-users');
                if (noUsers) noUsers.remove();

                const li = document.createElement('li');
                li.id = id;
                li.className = 'glass';
                li.style.padding = '0.75rem';
                li.style.marginBottom = '0.75rem';
                li.style.display = 'flex';
                li.style.alignItems = 'center';
                li.style.justifyContent = 'space-between';

                li.innerHTML = `
                        <div>
                            <span class="status-indicator status-online"></span>
                            <strong>${user.name}</strong>
                        </div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 0.25rem 0.5rem; border-radius: 4px;">${user.type}</span>
                    `;
                presenceList.appendChild(li);
            }
        }
    </script>
@endsection