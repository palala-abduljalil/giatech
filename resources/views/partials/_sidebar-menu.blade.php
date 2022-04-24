<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

		<li class="nav-header">BUSINESS</li>
		@can('canManageContent')
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-file-invoice"></i>
				<p>Content</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">

				<li class="nav-item">
					<a href="{{ route('content.business-overview') }}"
						class="{{ (request()->routeIs('content.business-overview')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Business Overview</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('content.team') }}"
						class="{{ (request()->routeIs('content.team')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Team</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('content.services') }}"
						class="{{ (request()->routeIs('content.services')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Services</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('content.freebies') }}"
						class="{{ (request()->routeIs('content.freebies')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Freebies</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('content.contact-details') }}"
						class="{{ (request()->routeIs('content.contact-details')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Contact Details</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan

		@can('canManageEmployees')
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-users"></i>
				<p>Employees</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('employees.index') }}"
						class="{{ (request()->routeIs('employees.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							List of Employees
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('employees.create') }}"
						class="{{ (request()->routeIs('employees.create')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Register Employee
						</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan


		@can('canManageUsers')
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-users"></i>
				<p>Users</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('users.index') }}"
						class="{{ (request()->routeIs('users.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							List of Users
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('users.create') }}"
						class="{{ (request()->routeIs('users.create')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Create User
						</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan

		@can('canManageClients')
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-user"></i>
				<p>Clients</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('clients.index') }}"
						class="{{ (request()->routeIs('clients.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							List of Clients
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('clients.create') }}"
						class="{{ (request()->routeIs('clients.create')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Register Client
						</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan

		@can('canManageProjects')
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-clipboard-list"></i>
				<p>Projects</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('projects.index') }}"
						class="{{ (request()->routeIs('projects.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							List of Projects
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('projects.create') }}"
						class="{{ (request()->routeIs('projects.create')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Create Project
						</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan


		@can('canManageFinance')
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-file-invoice-dollar"></i>
				<p>Finance</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('expenses.index') }}"
						class="{{ (request()->routeIs('expenses.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Expenses
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('expenses-transportation.index') }}"
						class="{{ (request()->routeIs('expenses-transportation.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Transportation Expense
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('incomes.index') }}"
						class="{{ (request()->routeIs('incomes.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Income
						</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan

		@can('canGenerateReports')
		<li class="nav-header">REPORT</li>
		<li class="nav-item">
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-chart-pie"></i>
				<p>Report</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('employee-report.index') }}"
						class="{{ (request()->routeIs('employee-report.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Employee
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('client-report.index') }}"
						class="{{ (request()->routeIs('client-report.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Client
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('project-report.index') }}"
						class="{{ (request()->routeIs('project-report.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Project
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('expense-report.index') }}"
						class="{{ (request()->routeIs('expense-report.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Expense
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('income-report.index') }}"
						class="{{ (request()->routeIs('income-report.index')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>
							Income
						</p>
					</a>
				</li>
			</ul>
		</li>
		</li>
		@endcan

		@can('isAdmin')
		<li class="nav-header">SETTINGS</li>
		<li class="nav-item">
			<a href="{{ route('activity-logs.index') }}"
				class="{{ (request()->routeIs('activity-logs.index')) ? 'active' : '' }} nav-link">
				<i class="nav-icon fas fa-history"></i>
				<p>Activity Logs</p>
			</a>
		</li>
		<li class="nav-item has-treeview">
			<a href="#" class="nav-link">
				<i class="fas fa-cogs nav-icon"></i>
				<p>System Setup</p>
				<i class="right fas fa-angle-left"></i>
			</a>
			<ul class="nav nav-treeview">

				<li class="nav-item">
					<a href="{{ route('system-setup.security-questions') }}"
						class="{{ (request()->routeIs('system-setup.security-questions')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Security Questions</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.positions') }}"
						class="{{ (request()->routeIs('system-setup.positions')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Positions</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.departments') }}"
						class="{{ (request()->routeIs('system-setup.departments')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Department</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.expenses.category') }}"
						class="{{ (request()->routeIs('system-setup.expenses.category')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Expense Category</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.incomes.category') }}"
						class="{{ (request()->routeIs('system-setup.incomes.category')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Income Category</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.employee.status') }}"
						class="{{ (request()->routeIs('system-setup.employee.status')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Employee Status</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.academic.degrees') }}"
						class="{{ (request()->routeIs('system-setup.academic.degrees')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Academic Degree</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.schools') }}"
						class="{{ (request()->routeIs('system-setup.schools')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Schools</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.project.status') }}"
						class="{{ (request()->routeIs('system-setup.project.status')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Project Status</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('system-setup.project.category') }}"
						class="{{ (request()->routeIs('system-setup.project.category')) ? 'active' : '' }} nav-link">
						<i class="nav-icon far fa-circle"></i>
						<p>Project Category</p>
					</a>
				</li>
			</ul>
		</li>
		@endcan

		<li class="nav-item">
			<a href="#" class="nav-link" onclick="event.preventDefault();
          		document.getElementById('logout-sidebar-form').submit();">
				<i class="nav-icon fas fa-power-off"></i>
				<p>
					{{ __('Logout') }}
				</p>
			</a>
			<form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		</li>
	</ul>
</nav>