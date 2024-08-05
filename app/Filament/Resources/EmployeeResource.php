<?php
namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\City; // City modelini eklemelisiniz
use App\Models\Country; // Country modelini eklemelisiniz
use App\Models\Department; // Department modelini eklemelisiniz
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Employees';

    protected static ?string $modelLabel = 'Employees';
    
    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Relationships')
                    ->description('Put The Address Details Here.')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name') // `name` yerine `Country` modelinin uygun özelliği
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(false),
                        
                        Forms\Components\Select::make('state_id')
                            ->options(fn ($get): Collection => City::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(false),
                        
                        Forms\Components\Select::make('city_id')
                            ->options(fn ($get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(false),
                        
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name') // `name` yerine `Department` modelinin uygun özelliği
                            ->searchable()
                            ->preload()
                            ->required(false),
                    ])->columns(2),
                
                Forms\Components\Section::make('User Name')
                    ->description('Put The User Name Details Here.')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('middle_name')
                            ->maxLength(255),
                    ])->columns(3),
                
                Forms\Components\Section::make('User Address')
                    ->description('Put The Address Details Here.')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('zip_code')
                            ->required()
                            ->maxLength(10),
                    ])->columns(2),
                
                Forms\Components\Section::make('Date')
                    ->description('Put The Date Details Here.')
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required(),
                        
                        Forms\Components\DatePicker::make('date_hired')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country_id')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('state_id')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('city_id')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('department_id')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            // Define relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}

