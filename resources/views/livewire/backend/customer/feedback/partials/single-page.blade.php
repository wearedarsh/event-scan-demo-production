<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
    <div class="form-group mx-auto mw450">
        <div class="row">
            @foreach ($form->groups as $group)
                <div class="mb-5">
                    <h5 class="mb-3">{{ $group->title }}</h5>

                    @foreach ($group->questions as $question)
                        @php
                            $is_conditional = $question->visible_if_question_id && $question->visible_if_answer;
                            $default_visible = !$is_conditional || (($answers[$question->visible_if_question_id] ?? null) === trim($question->visible_if_answer));
                        @endphp

                        <div
                            @if($is_conditional)
                                x-data="{ visible: @js($default_visible) }"
                                x-show="visible"
                                x-transition
                                x-init="
                                    $watch(() => $wire.answers[{{ $question->visible_if_question_id }}], value => {
                                        const norm = (v) => (typeof v === 'string') ? v.trim().replace(/\s+/g,' ') : String(v ?? '');
                                        visible = norm(value) === norm(@js($question->visible_if_answer));
                                    })
                                "
                            @endif
                            class="mb-4"
                        >
                            <label class="form-label fw-bold d-block">{{ $question->question }}</label>

                            @error('answers.' . $question->id)
                                <div class="bg-brand-primary rounded-1 p-1 px-2 mb-2">
                                    <span class="font-m text-brand-light">{{ $message }}</span>
                                </div>
                            @enderror

                            @if ($question->type === 'text')
                                <input type="text"
                                       class="form-control"
                                       wire:model.lazy="answers.{{ $question->id }}">

                            @elseif ($question->type === 'textarea')
                                <textarea class="form-control"
                                          wire:model.lazy="answers.{{ $question->id }}"></textarea>

                            @elseif ($question->type === 'radio')
                                @foreach (explode(',', (string)$question->options_text) as $optionRaw)
                                    @php $option = trim($optionRaw); @endphp
                                    <div class="form-check">
                                        <input type="radio"
                                               class="form-check-input"
                                               id="question_{{ $question->id }}_option_{{ $loop->index }}"
                                               name="answers[{{ $question->id }}]"
                                               wire:model.defer="answers.{{ $question->id }}"
                                               value="{{ $option }}">
                                        <label class="form-check-label font-m"
                                               for="question_{{ $question->id }}_option_{{ $loop->index }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
