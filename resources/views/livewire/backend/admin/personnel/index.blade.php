<div class="space-y-6">

	<!-- Breadcrumbs -->
	<x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Personnel'],
    ]" />


	<!-- Page Header -->
	<div class="px-6">
		<h1 class="text-2xl font-semibold text-[var(--color-text)]">Personnel</h1>
		<p class="text-sm text-[var(--color-text-light)] mt-1">
			Manage personnel groups and individual personnel.
		</p>
	</div>


	<!-- Alerts -->
	@if($errors->any())
	<div class="px-6">
		<div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
			<p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
		</div>
	</div>
	@endif

	@if (session()->has('success'))
	<div class="px-6">
		<div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
			<p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
		</div>
	</div>
	@endif



	<!-- ============================================================= -->
	<!-- BADGES -->
	<!-- ============================================================= -->
	<div class="px-6">
		<div class="soft-card p-5 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition">

			<div>
				<h3 class="font-medium">Badges</h3>
				<p class="text-sm text-[var(--color-text-light)]">
					Export print-ready personnel badges.
				</p>
			</div>

			<x-link-arrow href="{{ route('admin.events.personnel.badges.export', $event->id) }}">
				Print badges
			</x-link-arrow>

		</div>
	</div>



	<!-- ============================================================= -->
	<!-- PERSONNEL GROUPS -->
	<!-- ============================================================= -->
	<div class="px-6 space-y-4">

		<x-admin.section-title title="Personnel groups" />

		<div class="soft-card p-5 space-y-4">

			<div class="flex items-center justify-between">
				<h3 class="font-medium">Groups</h3>

				<!-- Add Group -->
				<a href="{{ route('admin.events.personnel.groups.create', $event->id) }}"
					class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                  bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                  text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white
                  transition-colors duration-150">
					<x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
					<span class="hidden md:inline">Add group</span>
				</a>
			</div>


			<!-- Table -->
			<div class="relative overflow-x-auto">
				<div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-white pointer-events-none"></div>

				<table class="min-w-full text-sm text-left">
					<thead>
						<tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
							<th class="px-4 py-3">Group</th>
							<th class="px-4 py-3">Label</th>
							<th class="px-4 py-3 text-right">Actions</th>
						</tr>
					</thead>

					<tbody>
						@forelse($this->personnelGroups as $group)

						<tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">
							<td class="px-4 py-3">{{ $group->title }}</td>

							<td class="px-4 py-3">
								<span class="px-2 py-1 rounded text-xs"
									style="background: {{ $group->label_background_colour }};
                                                 color: {{ $group->label_colour }};">
									{{ $group->title }}
								</span>
							</td>

							<td class="px-4 py-3 text-right">
								<div class="flex items-center justify-end gap-2">

									<x-admin.table-action-button
										type="link"
										:href="route('admin.events.personnel.groups.edit', [
                                                'event' => $event->id,
                                                'personnel_group' => $group->id
                                            ])"
										icon="pencil-square"
										label="Edit" />

									@if($group->personnel->count() === 0)
									<x-admin.table-action-button
										type="button"
										confirm="Delete this group?"
										wireClick="deletePersonnelGroup({{ $group->id }})"
										icon="trash"
										label="Delete"
										danger="true" />
									@else
									<span class="text-xs text-[var(--color-text-light)]">
										In use
									</span>
									@endif

								</div>
							</td>
						</tr>

						@empty
						<tr>
							<td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
								No groups found.
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>

		</div>
	</div>



	<!-- ============================================================= -->
	<!-- PERSONNEL LIST -->
	<!-- ============================================================= -->
	<div class="px-6 space-y-4">

		<x-admin.section-title title="Personnel" />

		<div class="soft-card p-5 space-y-4">


			<!-- Filters -->
			<div class="grid sm:grid-cols-3 gap-4">
				<input
					type="text"
					wire:model.live.debounce.300ms="search"
					placeholder="Search name or group"
					class="input-text">

				<x-admin.select wire:model.live="group_filter">
					<option value="">All Groups</option>
					@foreach($this->personnelGroups as $group)
					<option value="{{ $group->id }}">{{ $group->title }}</option>
					@endforeach
				</x-admin.select>

				<!-- Add Personnel -->
				<a href="{{ route('admin.events.personnel.create', $event->id) }}"
					class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                  bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                  text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white
                  transition-colors duration-150">
					<x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
					<span class="hidden md:inline">Add personnel</span>
				</a>
			</div>


			<!-- Table -->
			<div class="relative overflow-x-auto">
				<div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-white pointer-events-none"></div>

				<table class="min-w-full text-sm text-left">
					<thead>
						<tr class="text-xs uppercase text-[var(--color-text-light)]
                                   border-b border-[var(--color-border)]">
							<th class="px-4 py-3">Line 1</th>
							<th class="px-4 py-3">Line 2</th>
							<th class="px-4 py-3">Line 3</th>
							<th class="px-4 py-3">Group</th>
							<th class="px-4 py-3 text-right">Actions</th>
						</tr>
					</thead>

					<tbody>
						@forelse($personnel as $person)

						<tr class="border-b border-[var(--color-border)]
                                       hover:bg-[var(--color-surface-hover)] transition">

							<td class="px-4 py-3">{{ $person->line_1 }}</td>
							<td class="px-4 py-3">{{ $person->line_2 }}</td>
							<td class="px-4 py-3">{{ $person->line_3 }}</td>

							<td class="px-4 py-3">
								@if($person->group)
								<span class="px-2 py-1 rounded text-xs"
									style="background: {{ $person->group->label_background_colour }};
                                                     color: {{ $person->group->label_colour }};">
									{{ $person->group->title }}
								</span>
								@endif
							</td>

							<td class="px-4 py-3 text-right">
								<div class="flex justify-end items-center gap-2">

									<x-admin.table-action-button
										type="link"
										:href="route('admin.events.personnel.edit', [
                                                'event' => $event->id,
                                                'personnel' => $person->id
                                            ])"
										icon="pencil-square"
										label="Edit" />

									<x-admin.table-action-button
										type="button"
										danger="true"
										confirm="Delete this personnel?"
										wireClick="delete({{ $person->id }})"
										icon="trash"
										label="Delete" />

								</div>
							</td>

						</tr>

						@empty
						<tr>
							<td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
								No personnel found.
							</td>
						</tr>
						@endforelse
					</tbody>

				</table>
			</div>


			<!-- Pagination -->
			<div>
				{{ $personnel->links() }}
			</div>

		</div>
	</div>

</div>