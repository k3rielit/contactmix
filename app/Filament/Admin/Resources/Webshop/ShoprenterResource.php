<?php

namespace App\Filament\Admin\Resources\Webshop;

use App\Filament\Admin\Resources\Webshop\ShoprenterResource\Pages;
use App\Filament\Admin\Resources\Webshop\ShoprenterResource\RelationManagers;
use App\Filament\Components\Actions\GoToFormAction;
use App\Filament\Components\Actions\LargeImagePreviewTableAction;
use App\Forms\Components\IframePreview;
use App\Forms\Components\ImagePreview;
use App\Models\Webshop\Shoprenter;
use Filament\Forms;
use Filament\Forms\Components\Actions as FormActions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShoprenterResource extends Resource
{

    protected static ?string $model = Shoprenter::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getModelLabel(): string
    {
        return "Shoprenter";
    }

    public static function getPluralModelLabel(): string
    {
        return "Shoprenter";
    }

    public static function getNavigationLabel(): string
    {
        return "Shoprenter";
    }

    public static function getNavigationGroup(): ?string
    {
        return "Webshop";
    }

    public static function getNavigationBadge(): ?string
    {
        return Shoprenter::query()->count();
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
                    ImagePreview::make('image_url')->source(fn(Shoprenter $record) => $record?->image_url),
                ]),
                Forms\Components\Section::make('Contacts')->visibleOn('view')->icon('heroicon-o-phone')->columnSpanFull()->columns(1)->compact()->collapsible()->collapsed()->schema([
                    FormActions::make([
                        GoToFormAction::make('open_contacts_page')->url(fn(Shoprenter $record) => $record?->contacts_page_url, true),
                    ])->fullWidth()->alignCenter(),
                    IframePreview::make('contacts_page')->source(fn(Shoprenter $record) => $record?->contacts_page_url),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('favicon')->toggleable(),
                Tables\Columns\ImageColumn::make('image_url')->tooltip('Preview')->toggleable()->action(LargeImagePreviewTableAction::make()->imageUrl(fn(Shoprenter $record) => $record->image_url)),
                Tables\Columns\IconColumn::make('checked')->boolean()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('url')->tooltip('Open')->searchable()->sortable()->toggleable()->url(fn(Shoprenter $record) => $record->url, true),
                Tables\Columns\TextColumn::make('contacts_page_url')->tooltip('Open')->toggleable()->url(fn(Shoprenter $record) => $record->contacts_page_url, true),
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
                Tables\Actions\ViewAction::make()->modalWidth(MaxWidth::Screen)->modalCancelAction(false),
                Tables\Actions\EditAction::make()->modalWidth(MaxWidth::Screen),
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
            'index' => Pages\ListShoprenters::route('/'),
            //'create' => Pages\CreateShoprenter::route('/create'),
            //'view' => Pages\ViewShoprenter::route('/{record}'),
            //'edit' => Pages\EditShoprenter::route('/{record}/edit'),
        ];
    }

}
