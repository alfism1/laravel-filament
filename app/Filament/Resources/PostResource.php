<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Post Details')
                            ->schema([
                                TextInput::make('title')->minLength(3)->maxLength(20)->required(),
                                TextInput::make('slug')->unique(ignoreRecord: true)->required(),
                                Select::make('category_id')
                                    ->options(Category::all()->pluck('name', 'id'))
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->required(),

                                ColorPicker::make('color')->required(),
                                MarkdownEditor::make('content')->required()->columnSpanFull(),
                            ]),
                        Tab::make('Image')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label('')
                                    ->disk('public')
                                    ->directory('thumbnails')
                                    ->acceptedFileTypes(['image/*'])
                                    ->nullable(),
                            ]),
                        Tab::make('Meta')
                            ->schema([
                                TagsInput::make('tags')->required(),
                                Checkbox::make('published'),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),

                // Section::make('Post Details')
                //     ->description('Details about the post.')
                //     ->schema([
                //         TextInput::make('title')->minLength(3)->maxLength(20)->required(),
                //         TextInput::make('slug')->unique(ignoreRecord: true)->required(),
                //         Select::make('category_id')
                //             ->options(Category::all()->pluck('name', 'id'))
                //             ->label('Category')
                //             ->relationship('category', 'name')
                //             ->searchable()
                //             ->required(),

                //         ColorPicker::make('color')->required(),
                //         MarkdownEditor::make('content')->required()->columnSpanFull(),
                //     ])->columns(2)->columnSpan(2),

                // Group::make()->schema([
                //     Section::make('Image')
                //         ->schema([
                //             FileUpload::make('thumbnail')
                //                 ->disk('public')
                //                 ->directory('thumbnails')
                //                 ->acceptedFileTypes(['image/*'])
                //                 ->nullable(),
                //         ])
                //         ->collapsible()
                //         ->columns(1)->columnSpan(1),
                //     Section::make('Meta')
                //         ->schema([
                //             TagsInput::make('tags')->required(),
                //             Checkbox::make('published'),
                //         ])->columns(1)->columnSpan(1),
                // ]),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->toggleable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->toggleable(),
                TextColumn::make('title')->label('Title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('tags')
                    ->toggleable(),
                CheckboxColumn::make('published')
                    ->label('Published')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                // Filter::make('Published Posts')->query(
                //     fn (Builder $query) => $query->where('published', true)
                // ),
                TernaryFilter::make('published')
                    ->label('Published')
                    ->options([
                        'Published' => true,
                        'Not Published' => false,
                    ]),
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuthorsRelationManager::class,
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
