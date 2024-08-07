<?php

namespace App\Filament\Admin\Resources\Webshop;

use App\Filament\Admin\Resources\Webshop\UnasResource\Pages;
use App\Filament\Admin\Resources\Webshop\UnasResource\RelationManagers;
use App\Filament\Components\Actions\GoToFormAction;
use App\Filament\Components\Actions\LargeImagePreviewTableAction;
use App\Forms\Components\IframePreview;
use App\Forms\Components\ImagePreview;
use App\Models\Webshop\Unas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions as FormActions;

class UnasResource extends Resource
{

    protected static ?string $model = Unas::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getModelLabel(): string
    {
        return "UNAS";
    }

    public static function getPluralModelLabel(): string
    {
        return "UNAS";
    }

    public static function getNavigationLabel(): string
    {
        return "UNAS";
    }

    public static function getNavigationGroup(): ?string
    {
        return "Webshop";
    }

    public static function getNavigationBadge(): ?string
    {
        return Unas::query()->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Settings')->columnSpanFull()->columns(1)->compact()->collapsible()->schema([
                    Forms\Components\ToggleButtons::make('checked')->boolean()->inline(),
                ]),
                Forms\Components\Section::make('Attributes')->columnSpanFull()->columns(2)->compact()->collapsible()->schema([
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\TextInput::make('url'),
                    Forms\Components\TextInput::make('image_url'),
                ]),
                Forms\Components\Section::make('Image')->visibleOn('view')->icon('heroicon-o-photo')->columnSpanFull()->columns(1)->compact()->collapsible()->collapsed()->schema([
                    ImagePreview::make('image_url')->source(fn(Unas $record) => $record?->image_url),
                ]),
                Forms\Components\Section::make('Contacts')->visibleOn('view')->icon('heroicon-o-phone')->columnSpanFull()->columns(1)->compact()->collapsible()->collapsed()->schema([
                    FormActions::make([
                        GoToFormAction::make('open_contacts_page')->url(fn(Unas $record) => $record?->contacts_page_url, true),
                    ])->fullWidth()->alignCenter(),
                    IframePreview::make('contacts_page')->source(fn(Unas $record) => $record?->contacts_page_url),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('favicon')->toggleable(),
                Tables\Columns\ImageColumn::make('image_url')->tooltip('Preview')->toggleable()->action(LargeImagePreviewTableAction::make()->imageUrl(fn(Unas $record) => $record->image_url)),
                Tables\Columns\IconColumn::make('checked')->boolean()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('url')->tooltip('Open')->searchable()->sortable()->toggleable()->url(fn(Unas $record) => $record->url, true),
                Tables\Columns\TextColumn::make('contacts_page_url')->tooltip('Open')->toggleable()->url(fn(Unas $record) => $record->contacts_page_url, true),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y.m.d. H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('Y.m.d. H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->filters([
                Tables\Filters\Filter::make('checked')->form([
                    Forms\Components\ToggleButtons::make('checked')->boolean()->inline()->multiple(),
                ])->query(function (Builder $query, array $data): Builder {
                    $checked = $data['checked'];
                    if(count($checked) > 0) {
                        $query->whereIn('checked', $checked);
                    }
                    return $query;
                }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->modalWidth(MaxWidth::Full)->modalCancelAction(false),
                Tables\Actions\EditAction::make()->modalWidth(MaxWidth::Full),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnas::route('/'),
            //'create' => Pages\CreateUnas::route('/create'),
            //'view' => Pages\ViewUnas::route('/{record}'),
            //'edit' => Pages\EditUnas::route('/{record}/edit'),
        ];
    }
}
