<div class="search-document-content mb-3">
    <div class="preview">
        <img class="img-fluid" src="{{ $entry->links[0]->url }}/preview" alt="">
    </div>
    <div class="informations ml-3">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="text-3xs text-neutral">Ged -> Document</div>
                <a href="{{preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url)}}" class="font-bold">
                    {{$entry->name}}
                </a>
            </div>
            <div class="col-6">
                <div class="field">
                    <div class="field-label">Entité</div>
                    <div class="field-value text-truncate text-xs">
                        {{ !empty($entry->fields->entity->name) ? $entry->fields->entity->name : '-' }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <div class="field-label">Fournisseur</div>
                    <div class="field-value text-truncate text-xs">
                        {{ !empty($entry->fields->supplier->name) ? $entry->fields->supplier->name : '-' }}
                    </div>
                </div>
            </div>
            @if($entry->fields->doctype->code && $entry->fields->doctype->code === 'INVOICE')
                <div class="col-6">
                    <div class="field">
                        <div class="field-label">N° de facture</div>
                        <div class="field-value text-truncate text-xs">
                            {{ $entry->fields->reference_invoice }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="field">
                        <div class="field-label">Contrat</div>
                        <div class="field-value text-truncate text-xs">
                            {{ !empty($entry->fields->contract->name) ? $entry->fields->contract->name : '-' }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="field">
                        <div class="field-label">Date de facturation</div>
                        <div class="field-value text-truncate text-xs">
                            {{ !empty($entry->fields->date_invoice) ? \Carbon\Carbon::parse($entry->fields->date_invoice)->format('j/m/Y') : '-' }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="field">
                        <div class="field-label">Montant H.T.</div>
                        <div class="field-value text-truncate text-xs">
                            {{ !empty($entry->fields->amount_tax_excluded) ? number_format($entry->fields->amount_tax_excluded, 2, '.', ',') : '-' }} €
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
