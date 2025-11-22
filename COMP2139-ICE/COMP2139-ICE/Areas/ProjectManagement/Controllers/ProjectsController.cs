using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using COMP2139_ICE.Data;
using COMP2139_ICE.Areas.ProjectManagement.Models;

namespace COMP2139_ICE.Areas.ProjectManagement.Controllers;

[Area("ProjectManagement")]
[Route("[area]/[controller]/[action]")]
public class ProjectsController : Controller
{
    private readonly ApplicationDbContext _context;

    public ProjectsController(ApplicationDbContext context)
    {
        _context = context;
    }

    [HttpGet]
    public async Task<IActionResult> Search(string searchString)
    {
        var projectsQuery = from p in _context.Projects
                            select p;

        bool searchPerformed = !String.IsNullOrEmpty(searchString);

        if (searchPerformed)
        {
            projectsQuery = projectsQuery.Where(p => p.Name.Contains(searchString) 
                                                  || p.Description.Contains(searchString));
        }

        var projects = await projectsQuery.ToListAsync();
        ViewData["CurrentFilter"] = searchString;
        ViewData["SearchPerformed"] = searchPerformed;

        return View("Index", projects);
    }

    public async Task<IActionResult> Index()
    {
        return View(await _context.Projects.ToListAsync());
    }

    public async Task<IActionResult> Details(int? id)
    {
        if (id == null) return NotFound();
        var project = await _context.Projects.FirstOrDefaultAsync(m => m.ProjectId == id);
        if (project == null) return NotFound();
        return View(project);
    }

    public IActionResult Create()
    {
        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Create(Project project)
    {
        if (ModelState.IsValid)
        {
            _context.Add(project);
            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }
        return View(project);
    }

    public async Task<IActionResult> Edit(int? id)
    {
        if (id == null) return NotFound();
        var project = await _context.Projects.FindAsync(id);
        if (project == null) return NotFound();
        return View(project);
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Edit(int id, Project project)
    {
        if (id != project.ProjectId) return NotFound();
        if (ModelState.IsValid)
        {
            _context.Update(project);
            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }
        return View(project);
    }

    public async Task<IActionResult> Delete(int? id)
    {
        if (id == null) return NotFound();
        var project = await _context.Projects.FirstOrDefaultAsync(m => m.ProjectId == id);
        if (project == null) return NotFound();
        return View(project);
    }

    [HttpPost, ActionName("Delete")]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> DeleteConfirmed(int id)
    {
        var project = await _context.Projects.FindAsync(id);
        if (project != null)
        {
            _context.Projects.Remove(project);
            await _context.SaveChangesAsync();
        }
        return RedirectToAction(nameof(Index));
    }
}